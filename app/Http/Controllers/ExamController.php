<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Exam;
use App\Models\ApplicationStageProgress;
use App\Models\Scholarship;
use App\Models\ApplicationStage;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
   public function create($scholarshipID)
{
    try {
        $allEligible = $this->showEligibleForExam($scholarshipID);
    } catch (\Exception $e) {
        $message = "The exam stage is not available for this scholarship.";
        $eligibleApplications = collect();
        $exams = collect();
        return view('supervisor.examResult', compact('message', 'eligibleApplications', 'scholarshipID', 'exams'));
    }

    // filter applications that do NOT have an exam yet
    $eligibleApplications = $allEligible->filter(function ($item) {
        return is_null($item->application->idExam);
    });

    // fetch only exams related to this scholarship
    $applicationIds = Application::where('idScholarship', $scholarshipID)
        ->whereNotNull('idExam')
        ->pluck('idExam');

    $exams = Exam::whereIn('examID', $applicationIds)
        ->with(['application.user']) // eager load
        ->latest()
        ->get();

    return view('supervisor.examResult', compact('eligibleApplications', 'scholarshipID', 'exams'));
}

    public function store(Request $request, $scholarshipID)
    {
        $eligibleStudentIds = $this->showEligibleForExam($scholarshipID)
            ->pluck('application.user.id')
            ->toArray();

        $validated = $request->validate([
            'student_id' => ['required', Rule::in($eligibleStudentIds)],
            'score' => 'required|numeric',
            'status' => 'required|in:passed,failed',
            'exam_date' => 'required|date',
            'course' => 'required|string|max:255',
        ]);

        $exam = Exam::create([
            'score' => $validated['score'],
            'status' => $validated['status'],
            'exam_date' => $validated['exam_date'],
            'course' => $validated['course'],
        ]);

        $application = Application::where('idUser', $validated['student_id'])
            ->where('idScholarship', $scholarshipID)
            ->first();

        if ($application) {
            $application->idExam = $exam->examID;
            $application->save();
        }

        return redirect()->route('examResult.create', $scholarshipID)
            ->with('success', 'Exam result added successfully!');
    }


    // نفس الكود الذي جلبناه لجلب الطلاب المؤهلين
    public function showEligibleForExam($scholarshipID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);
        $examStage = $scholarship->applicationStages()
            ->where('name', 'Exam')
            ->firstOrFail();
        $previousStage = $scholarship->applicationStages()
            ->where('order', '<', $examStage->order)
            ->orderByDesc('order')
            ->firstOrFail();

        return ApplicationStageProgress::where('idAppStage', $previousStage->applicationStageID)
            ->where('status', 'accepted')
            ->with(['application.user', 'application.stageProgress' => function ($query) use ($examStage) {
                $query->where('idAppStage', $examStage->applicationStageID);
            }])
            ->get();
    }
    public function endExamStage($scholarshipID)
{
    // 1) Fetch the glorious “Exam” stage
    $examStage = ApplicationStage::where('idScholarship', $scholarshipID)
        ->where('name', 'Exam')
        ->firstOrFail();

    // 2) Bulk-reject the poor souls still “pending”
    $affected = ApplicationStageProgress::where('idAppStage', $examStage->applicationStageID)
        ->where('status', 'pending')
        ->update(['status' => 'rejected']);

    if ($affected === 0) {
        return redirect()->back()
            ->with('error', 'No pending exam-takers found—either they were all too punctual or nobody bothered to show up.');
    }

    // 3) Drag their parent Applications down with them
    $appIds = ApplicationStageProgress::where('idAppStage', $examStage->applicationStageID)
        ->where('status', 'rejected')
        ->pluck('idApp')
        ->unique()
        ->toArray();

    Application::whereIn('applicationID', $appIds)
        ->update(['status' => 'rejected']);

    // 4) Triumphantly report how many dreams were crushed
    return redirect()->back()
        ->with('success', "Exam stage closed! {$affected} applicant(s) mercilessly rejected.");
}

}
