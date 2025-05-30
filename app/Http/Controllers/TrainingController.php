<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo;
use App\Models\AdminScholarship;

class TrainingController extends Controller
{
    public function index()
    {
        
        return view('student.acadmic', compact('trainings'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $studentInfo = StudentInfo::where('idUser', Auth::id())->first(); // حسب المستخدم الحالي
   
        $path = null;
        if ($request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('certificates', 'public');
        }

        Training::create([
            'name' => $request->name,
            'certificate' => $path,
            'studentInfoID' => $studentInfo->studentInfoID,
        ]);

        return redirect()->back()->with('success', 'Training uploaded successfully!');

    }
   public function showActivities($scholarshipID)
{
    // 1. جيبي الـadmin ID
    $adminId = Auth::guard('admin')->id();

    // 2. تأكدي إنك فعلاً مالكة هالمِنحة
    $owns = AdminScholarship::where('admin_id', $adminId)
        ->where('idScholarship', $scholarshipID)
        ->exists();

   

    // 3. جيبي الطلاب اللي من منحتك وبس
    $students = StudentInfo::with(['user', 'trainings', 'volunteerings'])
        ->where('idScholarship', $scholarshipID)
        ->get();

    return view('supervisor.activities', compact('students', 'scholarshipID'));
}

}

