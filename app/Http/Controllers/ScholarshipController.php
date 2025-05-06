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
        return view('supervisor.scholarships', compact('scholarships'));
    }

    public function showEligibleForExam()
    {
        $adminId = Auth::guard('admin')->id();
    
        // Get all scholarships this admin is responsible for
        $scholarshipIDs = AdminScholarship::where('admin_id', $adminId)
            ->pluck('idScholarship');
    
        $allEligibleStudents = collect();
    
        foreach ($scholarshipIDs as $scholarshipID) {
            // Find the Exam stage for this specific scholarship
            $examStage = ApplicationStage::where('idScholarship', $scholarshipID)
                ->where('name', 'Exam')
                ->first();
    
            if (!$examStage) {
                continue; // No exam stage for this scholarship, skip it
            }
    
            // Find the previous stage before the Exam
            $previousStage = ApplicationStage::where('idScholarship', $scholarshipID)
                ->where('order', $examStage->order - 1)
                ->first();
    
            if (!$previousStage) {
                continue; // No previous stage found, skip
            }
    
            // Get applications that passed the previous stage
            $eligibleAppIDs = ApplicationStageProgress::where('idAppStage', $previousStage->applicationStageID)
                ->where('status', 'accepted')
                ->pluck('idApp');
    
            // Get students with their user details
            $students = Application::whereIn('applicationID', $eligibleAppIDs)
                ->with('user') // assuming you have 'user' relationship
                ->get();
    
            // Merge the students
            $allEligibleStudents = $allEligibleStudents->merge($students);
        }
    
        return view('supervisor.exam', [
            'students' => $allEligibleStudents,
            'scholarshipIDs' => $scholarshipIDs
        ]);
    }
    

    public function showExamDetails($studentID)
{
    $student = AllUser::findOrFail($studentID);
    $application = Application::where('idUser', $studentID)->first();

    if (!$application) {
        return back()->with('error', 'No application found for this student.');
    }

    // نجيب الستاج الأول (أو الي انت حابب تحدديه)
    $stage = ApplicationStage::orderBy('order', 'asc')->first(); // او حسب انتي شو بدك

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
    $student = AllUser::findOrFail($studentID);
    $application = Application::where('idUser', $studentID)->firstOrFail();

    // Find the "Exam" stage for the scholarship of this specific student
    $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
        ->where('name', 'Exam')
        ->first();

    if (!$examStage) {
        return back()->with('error', 'Exam stage not found.');
    }

    // Find the specific progress for this student and the exam stage
    $stageProgress = ApplicationStageProgress::where('idApp', $application->applicationID)
        ->where('idAppStage', $examStage->applicationStageID)
        ->first(); // No need for firstOrFail() here because we might create it if not found

    if ($stageProgress) {
        // Update the status to "accepted" for this exam stage only
        $stageProgress->update(['status' => 'accepted']);
    } else {
        // If progress doesn't exist, create it
        ApplicationStageProgress::create([
            'idApp' => $application->applicationID,
            'idAppStage' => $examStage->applicationStageID,
            'status' => 'accepted',
        ]);
    }

    return back()->with('success', 'Student approved successfully.');
}

public function rejectStudent($studentID)
{
    $student = AllUser::findOrFail($studentID);
    $application = Application::where('idUser', $studentID)->firstOrFail();

    // Find the "Exam" stage for the scholarship of this specific student
    $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
        ->where('name', 'Exam')
        ->first();

    if (!$examStage) {
        return back()->with('error', 'Exam stage not found.');
    }

    // Find the specific progress for this student and the exam stage
    $stageProgress = ApplicationStageProgress::where('idApp', $application->applicationID)
        ->where('idAppStage', $examStage->applicationStageID)
        ->first(); // Use first() instead of firstOrFail() to avoid breaking if not found

    if ($stageProgress) {
        // Update the status to "rejected" for this exam stage only
        $stageProgress->update(['status' => 'rejected']);
    } else {
        // If progress doesn't exist, create it
        ApplicationStageProgress::create([
            'idApp' => $application->applicationID,
            'idAppStage' => $examStage->applicationStageID,
            'status' => 'rejected',
        ]);
    }

    return back()->with('success', 'Student rejected successfully.');
}


public function sendInvitation($applicationID)
{
    // Get the application
    $application = Application::findOrFail($applicationID);

    // Find the "Exam" stage for the scholarship of this specific student
    $examStage = ApplicationStage::where('idScholarship', $application->idScholarship)
        ->where('name', 'Exam')
        ->first();

    if (!$examStage) {
        return back()->with('error', 'Exam stage not found.');
    }

    // Create the stage progress entry for the student in the "Exam" stage
    ApplicationStageProgress::create([
        'idApp' => $application->applicationID,
        'idAppStage' => $examStage->applicationStageID,
        'status' => 'pending', // Or set it to a specific status if needed
    ]);

    return back()->with('success', 'Invitation sent successfully.');
}


}
