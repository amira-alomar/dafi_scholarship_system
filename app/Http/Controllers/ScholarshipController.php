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

        // Get the scholarship
        $scholarship = Scholarship::findOrFail($scholarshipID);

        // Get the exam stage
        $examStage = $scholarship->applicationStages()
            ->where('name', 'Exam')
            ->firstOrFail();

        // Get the previous stage
        $previousStage = $scholarship->applicationStages()
            ->where('order', '<', $examStage->order)
            ->orderByDesc('order')
            ->firstOrFail();

        $eligibleApplications = ApplicationStageProgress::where('idAppStage', $previousStage->applicationStageID)
            ->where('status', 'accepted')
            ->with([
                'application.user',
                'application.stageProgress' => function ($query) use ($examStage) {
                    $query->where('idAppStage', $examStage->applicationStageID);
                }
            ])
            ->get();


        return view('supervisor.exam', compact('eligibleApplications', 'scholarshipID'));
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

        // // نجيب الستاج الأول (أو الي انت حابب تحدديه)
        // $stage = ApplicationStage::orderBy('order', 'asc')->first(); // او حسب انتي شو بدك

        // أول شي تجيبي مرحلة الامتحان الحقيقية
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

        return view('supervisor.exam_details', compact('student', 'exam', 'stageProgress'));
    }

    public function approveStudent($studentID)
    {
        // 1. تأكد من وجود المستخدم
        $student = AllUser::findOrFail($studentID);

        // 2. جلب أبليكشن (نفترض الأول) لهذا المستخدم
        $application = Application::where('idUser', $studentID)->firstOrFail();

        // 3. جلب مرحلة الامتحان (Exam) الخاصة بالمنحة
        $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Exam')
            ->firstOrFail();

        // 4. حاول تحديث الـ progress الموجود
        $affected = ApplicationStageProgress::where('idApp', $application->applicationID)
            ->where('idAppStage', $examStage->applicationStageID)
            ->update(['status' => 'accepted']);

        // 5. إذا لم يحدث أي صف، قم بإنشاء سجل جديد
        if ($affected === 0) {
            ApplicationStageProgress::create([
                'idApp'      => $application->applicationID,
                'idAppStage' => $examStage->applicationStageID,
                'status'     => 'accepted',
            ]);
        }

        return back()->with('success', 'Student approved successfully in the Exam stage.');
    }



    public function rejectStudent($studentID)
    {
        // تأكد من وجود المستخدم
        $student = AllUser::findOrFail($studentID);

        // جلب الأبليكشن المرتبط بالمستخدم (أول أبليكشن)
        $application = Application::where('idUser', $studentID)->firstOrFail();

        // جلب مرحلة الامتحان الخاصة بالمنحة
        $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Exam')
            ->firstOrFail();

        // حاول تحديث الـ progress الموجود
        $affected = ApplicationStageProgress::where('idApp', $application->applicationID)
            ->where('idAppStage', $examStage->applicationStageID)
            ->update(['status' => 'rejected']);

        // إذا لم يحدث أي صف، قم بإنشاء سجل جديد
        if ($affected === 0) {
            ApplicationStageProgress::create([
                'idApp'      => $application->applicationID,
                'idAppStage' => $examStage->applicationStageID,
                'status'     => 'rejected',
            ]);
        }

        return back()->with('success', 'Student rejected successfully in the Exam stage.');
    }



    public function sendInvitation($applicationID)
    {
        $application = Application::findOrFail($applicationID);

        $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
            ->where('name', 'Exam')
            ->first();

        if (!$examStage) {
            return back()->with('error', 'Exam stage not found.');
        }

        // Check if already sent
        $alreadySent = ApplicationStageProgress::where('idApp', $application->applicationID)
            ->where('idAppStage', $examStage->applicationStageID)
            ->exists();

        if ($alreadySent) {
            return back()->with('info', 'Invitation has already been sent.');
        }

        // Send the invitation
        ApplicationStageProgress::create([
            'idApp' => $application->applicationID,
            'idAppStage' => $examStage->applicationStageID,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Invitation sent successfully.');
    }

    public function manageScholarship($scholarshipID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);
        $applications = Application::where('idScholarship', $scholarshipID)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('supervisor.manageScholarship', compact('scholarshipID', 'scholarship', 'applications'));
    }
}
