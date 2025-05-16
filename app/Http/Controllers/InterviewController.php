<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\Application;
use App\Models\ApplicationStage;
use App\Models\ApplicationStageProgress;
use App\Models\AllUser;
use App\Models\Interview;
use Illuminate\Validation\Rule;

class InterviewController extends Controller
{
    public function showEligibleForInterview($scholarshipID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);

        $examStage = $scholarship->applicationStages()
            ->where('name', 'Exam')
            ->firstOrFail();

        $interviewStage = $scholarship->applicationStages()
            ->where('name', 'Interview')
            ->firstOrFail();

        $eligibleApplications = ApplicationStageProgress::where('idAppStage', $examStage->applicationStageID)
            ->where('status', 'accepted')
            ->with(['application.user', 'application.stageProgress' => function ($q) use ($interviewStage) {
                $q->where('idAppStage', $interviewStage->applicationStageID);
            }])
            ->get();

        return view('supervisor.interview', compact('eligibleApplications', 'scholarshipID'));
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
        $application = Application::findOrFail($applicationID);

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
    $student     = AllUser::findOrFail($studentID);
    $application = Application::where('idUser', $studentID)->firstOrFail();

    $interviewStage = ApplicationStage::where('idScholarship', $application->idScholarship)
        ->where('name', 'Interview')
        ->firstOrFail();

    $updated = ApplicationStageProgress::where('idApp', $application->applicationID)
        ->where('idAppStage', $interviewStage->applicationStageID)
        ->update(['status' => 'rejected']);

    if (! $updated) {
        ApplicationStageProgress::create([
            'idApp'      => $application->applicationID,
            'idAppStage' => $interviewStage->applicationStageID,
            'status'     => 'rejected',
        ]);
    }

    return back()->with('success', 'Student has been rejected from the interview stage.');
}


public function create($scholarshipID)
    {
        // 1. Find everyone who passed the **exam** and hasn't got an interview yet
        $eligible = $this->showEligibleForInterview1($scholarshipID)
            ->filter(fn($item) => is_null($item->application->idInterview));

        // 2. Grab existing interviews for this scholarship
        $interviewIds = Application::where('idScholarship', $scholarshipID)
            ->whereNotNull('idInterview')
            ->pluck('idInterview');

        $interviews = Interview::whereIn('interviewID', $interviewIds)
            ->with('application.user')
            ->latest()
            ->get();

        return view('supervisor.interviewResult', compact(
            'eligible', 'scholarshipID', 'interviews'
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
            'status'         => ['required', Rule::in(['scheduled','completed','canceled'])],
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
            ->where('name','Interview')
            ->firstOrFail();

        $prev = $scholarship->applicationStages()
            ->where('order','<',$interviewStage->order)
            ->orderByDesc('order')
            ->firstOrFail();

        return ApplicationStageProgress::where('idAppStage', $prev->applicationStageID)
            ->where('status','accepted')
            ->with([
                'application.user',
                'application.stageProgress' => fn($q) => 
                    $q->where('idAppStage',$interviewStage->applicationStageID)
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
}
