<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Exam;
use App\Models\ApplicationStageProgress;
use App\Models\Scholarship;
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
}
