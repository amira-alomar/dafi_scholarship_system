<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\Application;
use App\Http\Controllers\ApplicationController;
use App\Models\ApplicationStage;
use App\Models\AdminScholarship;
use App\Models\AllUser;
use App\Models\ApplicationStageProgress;
use App\Models\Exam;
use App\Mail\InvitatiobMail;
use Illuminate\Support\Facades\Mail;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Scholarship::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $scholarship = Scholarship::with(['criteria', 'benefits', 'partners'])->findOrFail($id);
        $hasApplied = false;
        if (Auth::check()) {
            $hasApplied = Application::where('idUser', Auth::id())
                ->where('idScholarship', $scholarship->scholarshipID)
                ->exists();
        }
        return view('candidate.scholarship_details', compact('scholarship', 'hasApplied'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function numberOfScholarship()
    {
        $count = Scholarship::count() ? Scholarship::count() : 0;
        return view('candidate.dashboard', compact('count'));
    }
    public function scholarshipOfEachSupervisor()
    {
        $supervisor = Auth::guard('admin')->user();
        $scholarships = $supervisor->scholarships;
        return view('supervisor.dashboard', compact('scholarships'));
    }

    public function showEligibleForExam($scholarshipID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);

        // 1) Grab the Form stage
        $formStage = $scholarship->applicationStages()
            ->where('name', 'Form')
            ->first();

        if (!$formStage) {
            // If there is no Form stage, nothing to do
            $message = 'Form stage not configured.';
            return view('supervisor.exam', compact('scholarshipID', 'message'))
                ->with('formClosed', false);
        }

        // 2) Check if any applicants are STILL pending in the Form stage
        $pendingCount = ApplicationStageProgress::where('idAppStage', $formStage->applicationStageID)
            ->where('status', 'pending')
            ->count();

        // If nobody is pending, we can start the Exam stage
        $formClosed = $pendingCount === 0;

        // 3) Now find the Exam stage itself
        $examStage = $scholarship->applicationStages()
            ->where('name', 'Exam')
            ->first();

        if (!$examStage) {
            $message = 'This stage is not available now.';
            return view('supervisor.exam', compact('scholarshipID', 'message', 'formClosed'));
        }

        // 4) Grab the stage immediately before Exam (should be Form)
        $previousStage = $scholarship->applicationStages()
            ->where('order', '<', $examStage->order)
            ->orderByDesc('order')
            ->first();

        if (!$previousStage) {
            $message = 'Previous stage not found.';
            return view('supervisor.exam', compact('scholarshipID', 'message', 'formClosed'));
        }

        // 5) Only pull in accepted apps from the previous stage if Form is closed
        $eligibleApplications = collect();
        if ($formClosed) {
            $eligibleApplications = ApplicationStageProgress::where('idAppStage', $previousStage->applicationStageID)
                ->where('status', 'accepted')
                ->with([
                    'application.user',
                    'application.stageProgress' => function ($query) use ($examStage) {
                        $query->where('idAppStage', $examStage->applicationStageID);
                    }
                ])
                ->get();
        }

        return view('supervisor.exam', compact(
            'eligibleApplications',
            'scholarshipID',
            'formClosed'
        ));
    }



    public function showExamDetails($studentID)
    {
        $student = AllUser::findOrFail($studentID);
        $stageProgress = ApplicationStageProgress::whereHas('application', function ($query) use ($studentID) {
            $query->where('idUser', $studentID);
        })->whereHas('stage', function ($query) {
            $query->where('name', 'Exam');
        })->first();

        $application = $stageProgress ? $stageProgress->application : null;


        if (!$application) {
            return back()->with('error', 'No application found for this student.');
        }


        $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Exam')
            ->first();

        if (!$examStage) {
            return back()->with('error', 'Exam stage not found.');
        }

        // بعدين تجيبي التقدم تبعها
        $stageProgress = ApplicationStageProgress::firstOrCreate(
            [
                'idApp' => $application->applicationID,
                'idAppStage' => $examStage->applicationStageID,
            ],
            ['status' => 'pending']
        );


        $exam = $application->exam;
        $scholarshipID = $application->idScholarship;

        return view('supervisor.exam_details', compact('student', 'exam', 'stageProgress', 'scholarshipID'));
    }

   public function approveStudent($studentID, $scholarshipID)
{
    // 1. Get the correct application for this student and scholarship
    $application = Application::where('idUser', $studentID)
        ->where('idScholarship', $scholarshipID)
        ->firstOrFail();

    // 2. Get the exam stage for this scholarship
    $examStage = ApplicationStage::where('idScholarship', $scholarshipID)
        ->where('name', 'Exam')
        ->firstOrFail();

    // 3. Try to update the existing progress record
    $affected = ApplicationStageProgress::where('idApp', $application->applicationID)
        ->where('idAppStage', $examStage->applicationStageID)
        ->update(['status' => 'accepted']);

    // 4. If no record was updated, create a new one
    if ($affected === 0) {
        ApplicationStageProgress::create([
            'idApp'      => $application->applicationID,
            'idAppStage' => $examStage->applicationStageID,
            'status'     => 'accepted',
        ]);
    }

    return back()->with('success', 'Student approved successfully in the Exam stage.');
}


    public function rejectStudent($studentID, $scholarshipID)
{
    // 1️⃣ Grab the precise application for this student + scholarship
    $application = Application::where('idUser', $studentID)
        ->where('idScholarship', $scholarshipID)
        ->firstOrFail();

    // 2️⃣ Find the “Exam” stage for that scholarship
    $examStage = ApplicationStage::where('idScholarship', $scholarshipID)
        ->where('name', 'Exam')
        ->firstOrFail();

    // 3️⃣ Try updating the existing progress record to ‘rejected’
    $affected = ApplicationStageProgress::where('idApp', $application->applicationID)
        ->where('idAppStage', $examStage->applicationStageID)
        ->update(['status' => 'rejected']);

    // 4️⃣ If nothing to update, create a fresh “rejected” record
    if ($affected === 0) {
        ApplicationStageProgress::create([
            'idApp'      => $application->applicationID,
            'idAppStage' => $examStage->applicationStageID,
            'status'     => 'rejected',
        ]);
    }

    // 5️⃣ Finally, kill the entire application—no partial credit here
    $application->update(['status' => 'rejected']);

    // 6️⃣ Send them back with triumphant flair
    return back()->with(
        'success',
        'Student mercilessly rejected at the Exam stage — application status is now REJECTED.'
    );
}





    public function sendInvitation(Request $request, $applicationID)
    {
        // 1) Validate the modal inputs
        $v = $request->validate([
            'exam_date'    => 'required|date',
            'exam_subject' => 'required|string|max:255',
            'exam_details' => 'nullable|string',
        ]);

        // 2) Fetch & check as you did before
        $application = Application::with('user')->findOrFail($applicationID);
        $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Exam')
            ->firstOrFail();

        $alreadySent = ApplicationStageProgress::where('idApp', $application->applicationID)
            ->where('idAppStage', $examStage->applicationStageID)
            ->exists();

        if ($alreadySent) {
            return back()->with('info', 'Invitation has already been sent.');
        }

        // 3) Create the normal Progress record
        ApplicationStageProgress::create([
            'idApp'      => $application->applicationID,
            'idAppStage' => $examStage->applicationStageID,
            'status'     => 'pending',
        ]);

        // 4) Send the mail, passing along our three new values
        Mail::to($application->user->email)
            ->send(new InvitatiobMail(
                $application,
                $v['exam_date'],
                $v['exam_subject'],
                $v['exam_details']
            ));

        return back()->with('success', 'Invitation sent successfully.');
    }

    public function manageScholarship($scholarshipID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);
        $applications = Application::where('idScholarship', $scholarshipID)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $acceptedStudents = Application::where('idScholarship', $scholarshipID)
            ->where('status', 'approved')
            ->count();

        $rejectedStudents = Application::where('idScholarship', $scholarshipID)
            ->where('status', 'rejected')
            ->count();

        $pendingStudents = Application::where('idScholarship', $scholarshipID)
            ->where('status', 'pending')
            ->count();

        return view('supervisor.manageScholarship', compact(
            'scholarshipID',
            'scholarship',
            'applications',
            'acceptedStudents',
            'rejectedStudents',
            'pendingStudents'
        ));
    }
}
