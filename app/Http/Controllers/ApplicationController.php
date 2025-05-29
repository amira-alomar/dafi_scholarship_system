<?php

namespace App\Http\Controllers;

use App\Mail\AcceptApplicaton;
use App\Mail\RejectApplicaton;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\AdminScholarship;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;
use App\Models\Answer;
use App\Models\ApplicationStage;
use App\Models\ApplicationStageProgress;
use App\Models\Scholarship;
use App\Models\Role;
use App\Models\AllUser;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function index($scholarshipId)
    {
        $formStage = ApplicationStage::where('idScholarship', $scholarshipId)
            ->where('name', 'Form')
            ->firstOrFail();

        $applications = Application::where('idScholarship', $scholarshipId)
            ->with(['user', 'scholarship', 'stageProgress'])
            ->get();

        // أضيفي formProgress لكل application إذا موجود
        foreach ($applications as $application) {
            $application->formProgress = $application->stageProgress
                ->firstWhere('idAppStage', $formStage->applicationStageID);
        }

        return view('supervisor.application', compact('applications', 'scholarshipId', 'formStage'));
    }
    public function showApplicationDetails($scholarshipId, $applicationID)
    {
        $application = Application::with([
            'applicationForm',
            'answers.question',
            'documents',
            'stageProgress'        // ← load all stage progresses
        ])
            ->where('applicationID', $applicationID)
            ->first();

        // bail if missing
        if (!$application) {
            return redirect()->back()->with('error', 'Application not found');
        }

        // grab the “Form” stage to filter
        $formStage = ApplicationStage::where('idScholarship', $scholarshipId)
            ->where('name', 'Form')
            ->firstOrFail();

        // find just the progress row for that stage
        $formProgress = $application
            ->stageProgress
            ->firstWhere('idAppStage', $formStage->applicationStageID);


        $requiredDocuments = \App\Models\RequiredDocument::with(['documents' => function ($query) use ($application) {
            $query->where('idApp', $application->applicationID);
        }])
            ->where('idScholarship', $scholarshipId) 
            ->get();


        return view('supervisor.applicationDetails', compact(
            'application',
            'requiredDocuments',
            'scholarshipId',
            'formProgress'   // ← new!
        ));
    }


    public function approveApplication($scholarshipId, $applicationID)
    {
        // 1. جلب مرحلة الـ "Form" الخاصة بالمنحة
        $formStage = ApplicationStage::where('idScholarship', $scholarshipId)
            ->where('name', 'Form')
            ->firstOrFail();

        // 2. تحديث الصف الواحد في جدول application_stage_progress
        $affected = ApplicationStageProgress::where('idApp', $applicationID)
            ->where('idAppStage', $formStage->applicationStageID)
            ->update(['status' => 'accepted']);

        if ($affected === 0) {
            return redirect()->back()->with('error', 'No matching ApplicationStageProgress found for approval.');
        }
        return redirect()
            ->route('supervisor.application', ['scholarshipId' => $scholarshipId])
            ->with('success', 'Application has been approved in the Form stage.');
    }

    public function rejectApplication($scholarshipId, $applicationID)
    {
        // 1. Get the Form stage
        $formStage = ApplicationStage::where('idScholarship', $scholarshipId)
            ->where('name', 'Form')
            ->firstOrFail();

        // 2. Update the specific Form stage status to "rejected"
        $affected = ApplicationStageProgress::where('idApp', $applicationID)
            ->where('idAppStage', $formStage->applicationStageID)
            ->update(['status' => 'rejected']);

        if ($affected === 0) {
            return redirect()->back()->with('error', 'No matching ApplicationStageProgress found for rejection.');
        }

        // 3. Also update the main application status to "rejected"
        Application::where('applicationID', $applicationID)
            ->update(['status' => 'rejected']);

        return redirect()
            ->route('supervisor.application', ['scholarshipId' => $scholarshipId])
            ->with('success', 'Application has been rejected in the Form stage, and status updated.');
    }



    public function endFormStage($scholarshipId)
    {
        // Fetch that glorious “Form” stage
        $formStage = ApplicationStage::where('idScholarship', $scholarshipId)
            ->where('name', 'Form')
            ->firstOrFail();

        // Bulk–reject every poor sod still “pending”
        $affectedProgress = ApplicationStageProgress::where('idAppStage', $formStage->applicationStageID)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        if ($affectedProgress === 0) {
            return redirect()->back()
                ->with('error', 'There were no pending applicants to reject. Either they’re all perfect, or nobody showed up.');
        }

        // Now drag their parent Applications into the abyss
        $applicationIds = ApplicationStageProgress::where('idAppStage', $formStage->applicationStageID)
            ->where('status', 'rejected')
            ->pluck('idApp')
            ->unique()
            ->toArray();

        Application::whereIn('applicationID', $applicationIds)
            ->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', "Form stage closed! {$affectedProgress} applicant(s) mercilessly rejected.");
    }

    public function apply(Request $request, $scholarshipId)
    {
        $user = Auth::user();
        $scholarship = Scholarship::findOrFail($scholarshipId);

        // Check if user already applied to this scholarship
        $existingApplication = Application::where('idUser', $user->id)
            ->where('idScholarship', $scholarship->scholarshipID)
            ->first();
        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this scholarship.');
        }
        // Step 2: Create new application form linked to this application
        $applicationForm = ApplicationForm::create([
            'user_id' => $user->id,
            'status' => 'submitted',
        ]);
        // Step 1: Create new application record (the user now officially applied)
        $application = Application::create([
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->scholarshipID,
            'status' => 'pending',
            'submission_date' => now(),
            'idUser' => $user->id,
            'idScholarship' => $scholarship->scholarshipID,
            'idForm' => $applicationForm->applicationFormID, // foreign key to application form table
        ]);
        // Step 3: Save answers and link them to the main application (not form)
        foreach ($request->input('answers') as $questionId => $answerText) {
            Answer::create([
                'idApp' => $application->applicationID, // foreign key to application table
                'user_id' => $user->id,
                'idQuestion' => $questionId,
                'answer_text' => $answerText,
            ]);
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $requiredDocumentId => $uploadedFile) {
                $path = $uploadedFile->store('documents');
                $application->documents()->create([
                    'required_document_id' => $requiredDocumentId,
                    'document_path' => $path,
                    'document_name' => $uploadedFile->getClientOriginalName(),
                    'idApp' => $application->applicationID,
                ]);
            }
        }

        //Step 4: Register application to each stage of the scholarship
        $stages = ApplicationStage::where('idScholarship', $scholarship->scholarshipID)
            ->where('order', 1)
            ->get();
        // dd($stages);
        foreach ($stages as $index => $stage) {
            ApplicationStageProgress::create([
                'idApp' => $application->applicationID,
                'idAppStage' => $stage->applicationStageID,
                'status' => 'pending',
            ]);
        }
        return redirect()->route('candidate.submitted');
    }
    public function submitted()
    {
        return view('candidate.submitted');
    }



    public function finalApplication($scholarshipID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);

        // كل الأبليكشنز مع بيانات المستخدم ومراحل التقديم
        $applications = Application::with([
            'user:id,fname',
            'stageProgress' => fn($q) => $q->with('stage')->orderBy('idAppStage')
        ])
            ->where('idScholarship', $scholarshipID)
            ->get();

        return view('supervisor.final_application', compact('applications', 'scholarshipID'));
    }

    // 2. حفظ الحالة النهائية (approve/reject)
    public function storeFinalApplication(Request $request, $scholarshipID)
    {
        $data = $request->validate([
            'application_id' => 'required|exists:applications,applicationID',
            'final_status'   => 'required|in:approved,rejected',
        ]);

        $app = Application::where('applicationID', $data['application_id'])
            ->where('idScholarship', $scholarshipID)
            ->firstOrFail();

        $app->status = $data['final_status'];
        $app->save();

        return redirect()
            ->route('supervisor.finalApplication', $scholarshipID)
            ->with('success', "The application status for {$app->user->fname} {$app->user->lname} has been changed to “{$data['final_status']}”.");
    }

    public function addNote(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'notes' => 'required|string|max:5000',
        ]);

        // Find the application and update the notes
        $application = Application::findOrFail($request->application_id);

        if ($request->has('notes') && $request->notes) {
            $application->notes = $request->notes;
            $application->save();
        }

        // Redirect to the final application page with the scholarship ID
        return redirect()->route('supervisor.finalApplication', ['scholarshipID' => $request->scholarshipID]);
    }
    public function acceptedStudents($scholarshipID)
    {
        $applications = Application::with([
            'user.studentInfo',
            'scholarship',
            'user.studentInfo.volunteerings',
            'user.studentInfo.trainings',
        ])
            ->where('idScholarship', $scholarshipID)
            ->where('status', 'approved')
            ->get();

        return view('supervisor.acceptedStudents', compact('applications', 'scholarshipID'));
    }
    public function approveFinalApplication($applicationID)
    {
        $application = Application::findOrFail($applicationID);

        if ($application->status !== 'pending') {
            return back()->with('info', 'This application is already ' . $application->status . '.');
        }

        $application->update(['status' => 'approved']);

        $studentRoleId = Role::where('role_name', 'Student')->value('id');
        $user = AllUser::findOrFail($application->idUser);
        $user->update(['role_id' => $studentRoleId]);

        $studentEmail = $user->email;
        Mail::to($studentEmail)->send(new AcceptApplicaton());

        return back()->with('success', 'Application approved and user role updated.');
    }


    public function rejectFinalApplication($applicationID)
    {
        $application = Application::findOrFail($applicationID);

        if ($application->status !== 'pending') {
            return back()->with('info', 'This application is already ' . $application->status . '.');
        }
        $user = AllUser::findOrFail($application->idUser);
        $application->update(['status' => 'rejected']);
        $studentEmail = $user->email;
        Mail::to($studentEmail)->send(new RejectApplicaton());
        return back()->with('success', 'Application rejected successfully.');
    }
}
