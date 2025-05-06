<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\AdminScholarship;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;
use App\Models\Answer;
use App\Models\ApplicationStage;
use App\Models\ApplicationStageProgress;
use App\Models\Scholarship;

class ApplicationController extends Controller
{
    public function index()
    {
        $adminId = Auth::guard('admin')->id();
        // Get all scholarships this admin is responsible for
        $scholarshipIds = AdminScholarship::where('admin_id', $adminId)
            ->pluck('idScholarship');
        // Get all applications for these scholarships
        $applications = Application::whereIn('idScholarship', $scholarshipIds)
            ->with(['user', 'scholarship'])
            ->get();
        return view('supervisor.application', compact('applications'));
    }
    public function showApplicationDetails($applicationID)
{
    $application = Application::with(['applicationForm', 'answers.question', 'documents'])
        ->where('applicationID', $applicationID)
        ->first();

    if (!$application) {
        return redirect()->back()->with('error', 'Application not found');
    }

    // Fetch all required documents + filter user's uploaded docs per document
    $requiredDocuments = \App\Models\RequiredDocument::with(['documents' => function($query) use ($application) {
        $query->where('idApp', $application->applicationID);
    }])->get();
    
    
    return view('supervisor.applicationDetails', compact('application', 'requiredDocuments'));
}

    public function approveApplication($applicationID)
    {
        // Fetch the application form associated with the applicationID
        $applicationForm = ApplicationForm::where('applicationFormID', $applicationID)->first();

        // Ensure the application form exists
        if (!$applicationForm) {
            return redirect()->back()->with('error', 'Application form not found');
        }

        // Update the status to "Accepted"
        $applicationForm->status = 'approved';
        $applicationForm->save();

        // Redirect with a success message
        return redirect()->route('supervisor.application')->with('success', 'Application has been accepted');
    }

    public function rejectApplication($applicationID)
    {
        // Fetch the application form associated with the applicationID
        $applicationForm = ApplicationForm::where('applicationFormID', $applicationID)->first();

        // Ensure the application form exists
        if (!$applicationForm) {
            return redirect()->back()->with('error', 'Application form not found');
        }

        // Update the status to "Rejected"
        $applicationForm->status = 'rejected';
        $applicationForm->save();

        // Redirect with a success message
        return redirect()->route('supervisor.application')->with('success', 'Application has been rejected');
    }
    public function acceptedStudents()
    {
        $adminId = Auth::guard('admin')->id();
        // Get all scholarships this admin is responsible for
        $scholarshipIds = AdminScholarship::where('admin_id', $adminId)
            ->pluck('idScholarship');
        // Get all applications for these scholarships
        $applications = Application::whereIn('idScholarship', $scholarshipIds)
            ->where('status', 'approved')
            ->with(['user', 'scholarship', 'user.studentInfo'])
            ->get();
        return view('supervisor.acceptedStudents', compact('applications'));
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
}
