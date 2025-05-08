<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Opportunity;
use App\Models\AcademicGoal;
use App\Models\Training;
use App\Models\volunteering;
use App\Models\StudentInfo;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function index()
    {
        $studentInfo = auth()->user()->studentInfo;
        $studentInfoID = $studentInfo->studentInfoID ?? null;
    
        return view('student.profile', [
            'goals' => $goals,
            'trainings' => $trainings,
            'volunteerings' => $volunteerings,
            'major' => optional($studentInfo)->major,
            'gpa' => optional($studentInfo)->gpa,
            'university' => optional($studentInfo->university)->name ?? null,
        ]);
    }
    public function show() {
        $user = auth()->user();
        $major = $user->major ?? null;
        return view('student.profile', compact('major'));
    }
    
    public function update(Request $request) {
        $user = auth()->user();
        $user->update($request->all());
        return redirect()->route('student.profile')->with('success', 'Profile updated!');
    }
    


}  