<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\Application;
use App\Models\ApplicationStage;
use App\Models\ApplicationStageProgress;
use App\Models\AllUser;
use App\Models\Interview;

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
        $student = AllUser::findOrFail($studentID);

        $application = Application::where('idUser', $studentID)->firstOrFail();

        $interviewStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Interview')
            ->firstOrFail();

        $stageProgress = ApplicationStageProgress::firstOrCreate(
            ['idApp' => $application->applicationID, 'idAppStage' => $interviewStage->applicationStageID],
            ['status' => 'scheduled']
        );

        $interview = Interview::where('applicationID', $application->applicationID)
            ->first();

        return view('supervisor.interview_details', compact('student', 'interview', 'stageProgress'));
    }

    public function scheduleInterview($studentID, Request $request)
    {
        $request->validate(['interview_date' => 'required|date']);

        $application = Application::where('idUser', $studentID)->firstOrFail();
        $interview = Interview::updateOrCreate(
            ['applicationID' => $application->applicationID],
            ['interview_date' => $request->input('interview_date'), 'status' => 'scheduled']
        );

        return back()->with('success', 'Interview scheduled for ' . $interview->interview_date);
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

