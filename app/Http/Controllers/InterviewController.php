<?php

namespace App\Http\Controllers;

use App\Mail\InterviewInvitationMail;
use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\Application;
use App\Models\ApplicationStage;
use App\Models\ApplicationStageProgress;
use App\Models\AllUser;
use App\Models\Interview;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

class InterviewController extends Controller
{
   public function showEligibleForInterview($scholarshipID)
{
    try {
        $scholarship = Scholarship::findOrFail($scholarshipID);

        // 1) Fetch the Exam and Interview stages
        $examStage = $scholarship->applicationStages()
            ->where('name', 'Exam')
            ->firstOrFail();
        $interviewStage = $scholarship->applicationStages()
            ->where('name', 'Interview')
            ->first();

        if (!$interviewStage) {
            $message = 'The Interview stage is not available for this scholarship.';
            // Even if it’s “not available,” we still want to tell them if Exam is closed or not
            $pendingCount = ApplicationStageProgress::where('idAppStage', $examStage->applicationStageID)
                ->where('status', 'pending')
                ->count();
            $examClosed = ($pendingCount === 0);
            return view('supervisor.interview', compact('message', 'scholarshipID', 'examClosed'));
        }

        // 2) Check if any Exam-stage applicants are still pending
        $pendingCount = ApplicationStageProgress::where('idAppStage', $examStage->applicationStageID)
            ->where('status', 'pending')
            ->count();
        $examClosed = ($pendingCount === 0);

        // 3) If Exam isn’t closed, bail out early with your flag
        if (! $examClosed) {
            $message = 'Interview stage cannot start yet—there are still applicants in the Exam stage.';
            return view('supervisor.interview', compact('message', 'scholarshipID', 'examClosed'));
        }

        // 4) Everyone who survived Exam (i.e. “accepted”) is now Interview-eligible
        $eligibleApplications = ApplicationStageProgress::where('idAppStage', $examStage->applicationStageID)
            ->where('status', 'accepted')
            ->with([
                'application.user',
                'application.stageProgress' => function ($q) use ($interviewStage) {
                    $q->where('idAppStage', $interviewStage->applicationStageID);
                }
            ])
            ->get();

        return view('supervisor.interview', compact('eligibleApplications', 'scholarshipID', 'examClosed'));

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        $message = 'Scholarship or Exam stage not found.';
        // Assume Exam still open if we can’t find it
        $examClosed = false;
        return view('supervisor.interview', compact('message', 'scholarshipID', 'examClosed'));
    }
}

    public function showInterviewDetails($studentID)
    {
        // نجيب الطالب
        $student = AllUser::findOrFail($studentID);

        // نجيب الأبليكيشن
        $application = Application::where('idUser', $studentID)->firstOrFail();

        // نجيب مرحلة المقابلة
        $interviewStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Interview')
            ->firstOrFail();

        // نجيب التقدم أو نعمل واحد جديد
        $stageProgress = ApplicationStageProgress::firstOrCreate(
            [
                'idApp' => $application->applicationID,
                'idAppStage' => $interviewStage->applicationStageID,
            ],
            ['status' => 'pending']
        );

        // نجيب المقابلة من العلاقة مباشرة
        $interview = $application->interview;

        return view('supervisor.interview_details', compact('student', 'interview', 'stageProgress'));
    }


    public function scheduleInterview($applicationID)
    {
        // 1. تجيب الطلبية (application)
        $application = Application::with('user')->findOrFail($applicationID);

        // 2. تجيب الـStage الخاص بالمقابلات
        $interviewStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Interview')
            ->first();

        if (! $interviewStage) {
            return back()->with('error', 'Interview stage not found.');
        }

        // 3. اتأكد إنه مهي موجودة قبل هيك
        $alreadyScheduled = ApplicationStageProgress::where('idApp', $application->applicationID)
            ->where('idAppStage', $interviewStage->applicationStageID)
            ->exists();

        if ($alreadyScheduled) {
            return back()->with('info', 'Interview already scheduled.');
        }

        // 4. احجز الـslot بإضافة صف جديد في application_stage_progress
        ApplicationStageProgress::create([
            'idApp'      => $application->applicationID,
            'idAppStage' => $interviewStage->applicationStageID,
            'status'     => 'pending',  // أو 'scheduled' لو بدك
        ]);
        $studentEmail = $application->user->email;
        Mail::to($studentEmail)->send(new InterviewInvitationMail());
        return back()->with('success', 'Interview scheduled successfully.');
    }

    public function acceptInterview($studentID)
    {
        // 1. Load student & application
        $student     = AllUser::findOrFail($studentID);
        $application = Application::where('idUser', $studentID)->firstOrFail();

        // 2. Find the “Interview” stage for this scholarship
        $interviewStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Interview')
            ->firstOrFail();

        // 3. Update or create the progress record
        $updated = ApplicationStageProgress::where('idApp', $application->applicationID)
            ->where('idAppStage', $interviewStage->applicationStageID)
            ->update(['status' => 'accepted']);

        if (! $updated) {
            ApplicationStageProgress::create([
                'idApp'      => $application->applicationID,
                'idAppStage' => $interviewStage->applicationStageID,
                'status'     => 'accepted',
            ]);
        }

        return back()->with('success', 'Student has been accepted for the interview stage.');
    }

    public function rejectInterview($studentID)
{
    // 1) Ensure the user exists
    $student = AllUser::findOrFail($studentID);

    // 2) Grab their application
    $application = Application::where('idUser', $studentID)
        ->firstOrFail();

    // 3) Fetch the “Interview” stage for this scholarship
    $interviewStage = ApplicationStage::where('idScholarship', $application->idScholarship)
        ->where('name', 'Interview')
        ->firstOrFail();

    // 4) Attempt to mark the interview progress as “rejected”
    $updated = ApplicationStageProgress::where('idApp', $application->applicationID)
        ->where('idAppStage', $interviewStage->applicationStageID)
        ->update(['status' => 'rejected']);

    // 5) If no progress row existed, create one and reject it
    if (! $updated) {
        ApplicationStageProgress::create([
            'idApp'      => $application->applicationID,
            'idAppStage' => $interviewStage->applicationStageID,
            'status'     => 'rejected',
        ]);
    }

    // 6) Finally, reject the entire application—no take-backs!
    Application::where('applicationID', $application->applicationID)
        ->update(['status' => 'rejected']);

    // 7) Send them back with the bad news
    return back()
        ->with('success', 'Student has been rejected from the Interview stage—application status set to REJECTED.');
}



public function create($scholarshipID)
{
    try {
        // 1. Find everyone who passed the **exam** and hasn't got an interview yet
        $eligible = $this->showEligibleForInterview1($scholarshipID)
            ->filter(fn($item) => is_null($item->application->idInterview));
    } catch (\Exception $e) {
        $message = "The interview stage is not available for this scholarship.";
        $eligible = collect();
        $interviews = collect();
        return view('supervisor.interviewResult', compact(
            'eligible',
            'scholarshipID',
            'interviews',
            'message'
        ));
    }

    // 2. Grab existing interviews for this scholarship
    $interviewIds = Application::where('idScholarship', $scholarshipID)
        ->whereNotNull('idInterview')
        ->pluck('idInterview');

    $interviews = Interview::whereIn('interviewID', $interviewIds)
        ->with('application.user')
        ->latest()
        ->get();

    return view('supervisor.interviewResult', compact(
        'eligible',
        'scholarshipID',
        'interviews'
    ));
}


    public function store(Request $request, $scholarshipID)
    {
        // Only these student IDs may be scheduled
        $validIds = $this->showEligibleForInterview1($scholarshipID)
            ->pluck('application.user.id')
            ->toArray();

        $v = $request->validate([
            'student_id'     => ['required', Rule::in($validIds)],
            'interview_date' => 'required|date',
            'status'         => ['required', Rule::in(['scheduled', 'completed', 'canceled'])],
        ]);

        // 1. Create the interview
        $interview = Interview::create([
            'interview_date' => $v['interview_date'],
            'status'         => $v['status'],
        ]);

        // 2. Link it to the application
        $app = Application::where('idUser', $v['student_id'])
            ->where('idScholarship', $scholarshipID)
            ->firstOrFail();
        $app->update(['idInterview' => $interview->interviewID]);

        return redirect()
            ->route('interviewResult.create', $scholarshipID)
            ->with('success', 'Interview scheduled successfully!');
    }

    private function showEligibleForInterview1($scholarshipID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);

        // find “Interview” stage and the one immediately before it (e.g. “Exam”)
        $interviewStage = $scholarship->applicationStages()
            ->where('name', 'Interview')
            ->firstOrFail();

        $prev = $scholarship->applicationStages()
            ->where('order', '<', $interviewStage->order)
            ->orderByDesc('order')
            ->firstOrFail();

        return ApplicationStageProgress::where('idAppStage', $prev->applicationStageID)
            ->where('status', 'accepted')
            ->with([
                'application.user',
                'application.stageProgress' => fn($q) =>
                $q->where('idAppStage', $interviewStage->applicationStageID)
            ])
            ->get();
    }










    public function completeInterview($studentID)
    {
        $application = Application::where('idUser', $studentID)->firstOrFail();
        $interview = Interview::where('applicationID', $application->applicationID)->firstOrFail();
        $interview->update(['status' => 'completed']);

        return back()->with('success', 'Interview marked as completed.');
    }

    public function cancelInterview($studentID)
    {
        $application = Application::where('idUser', $studentID)->firstOrFail();
        $interview = Interview::where('applicationID', $application->applicationID)->firstOrFail();
        $interview->update(['status' => 'canceled']);

        return back()->with('success', 'Interview has been canceled.');
    }
    public function endInterviewStage($scholarshipID)
{
    // 1) Summon the Interview stage for this scholarship
    $interviewStage = ApplicationStage::where('idScholarship', $scholarshipID)
        ->where('name', 'Interview')
        ->firstOrFail();

    // 2) Bulk-reject all the poor souls still “pending”
    $affectedProgress = ApplicationStageProgress::where('idAppStage', $interviewStage->applicationStageID)
        ->where('status', 'pending')
        ->update(['status' => 'rejected']);

    if ($affectedProgress === 0) {
        return redirect()->back()
            ->with('error', 'No pending interviewees found—either everyone’s superhuman, or nobody showed up.');
    }

    // 3) Drag their parent Application records down with them
    $applicationIds = ApplicationStageProgress::where('idAppStage', $interviewStage->applicationStageID)
        ->where('status', 'rejected')
        ->pluck('idApp')
        ->unique()
        ->toArray();

    Application::whereIn('applicationID', $applicationIds)
        ->update(['status' => 'rejected']);

    // 4) Victory lap
    return redirect()->back()
        ->with('success', "Interview stage closed! {$affectedProgress} applicant(s) mercilessly rejected.");
}

}
