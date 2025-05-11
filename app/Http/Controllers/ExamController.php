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
        // جلب الطلاب المؤهلين للامتحان
        $eligibleApplications = $this->showEligibleForExam($scholarshipID);

        return view('supervisor.examResult', compact('eligibleApplications','scholarshipID'));
    }

   public function store(Request $request, $scholarshipID)
    {
        $eligibleStudentIds = $this->showEligibleForExam($scholarshipID)
    ->pluck('application.user.id')
    ->toArray();

        // التحقق من المدخلات
        $validated = $request->validate([
           'student_id' => ['required', Rule::in($eligibleStudentIds)],
            'score' => 'required|numeric',
            'status' => 'required|in:passed,failed',
            'exam_date' => 'required|date',
            'course' => 'required|string|max:255',
        ]);

        // إنشاء سجل امتحان جديد
        $exam = Exam::create([
            'score' => $validated['score'],
            'status' => $validated['status'],
            'exam_date' => $validated['exam_date'],
            'course' => $validated['course'],
        ]);

        // ربط الامتحان بالتطبيق الخاص بالطالب
        $application = Application::where('idUser', $validated['student_id'])
            ->where('idScholarship', $scholarshipID)
            ->first();

        if ($application) {
            // إضافة idExam إلى جدول التطبيقات
            $application->idExam = $exam->examID;
            $application->save();
        }

        return redirect()->route('supervisor.exam', ['scholarshipID' => $scholarshipID])
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