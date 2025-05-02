<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Opportunity;
use App\Models\UserOpportunity;
use App\Models\AcademicGoal;
use App\Models\Training;
use App\Models\volunteering;
use Illuminate\Support\Facades\Auth;
class AcadmicController extends Controller{
    public function index()
    {
        $studentInfo = auth()->user()->studentInfo;
        $studentInfoID = $studentInfo->studentInfoID ?? null;
    
        $trainings = $studentInfoID ? Training::where('studentInfoID', $studentInfoID)->get() : collect();
        $volunteerings = $studentInfoID ? volunteering::where('studentInfoID', $studentInfoID)->get() : collect();
        $goals = $studentInfo ? $studentInfo->academicGoals : collect();
    
        return view('student.acadmic', [
            'goals' => $goals,
            'trainings' => $trainings,
            'volunteerings' => $volunteerings,
            'major' => optional($studentInfo)->major,
            'gpa' => optional($studentInfo)->gpa,
            'university' => optional($studentInfo->university)->name ?? null,
        ]);
    }
    
public function store(Request $request)
{
    $request->validate([
        'gpa' => 'required|numeric|min:0|max:4',
        'major' => 'required|string|max:255',
        'training_certificate' => 'nullable|file|mimes:pdf,jpg,png',
        'volunteering_certificate' => 'nullable|file|mimes:pdf,jpg,png',
        'grades' => 'nullable|file|mimes:pdf,jpg,png',
    ]);

    $student = StudentInfo::updateOrCreate(
        ['idUser' => auth()->id()],
        [
            'gpa' => $request->gpa,
            'major' => $request->major,
            'year' => now()->year,
            'number_of_training' => 1,  
            'number_of_volunteering' => 1,
            'idUni' => 1, 
        ]
    );

    
    if ($request->hasFile('training_certificate')) {
        $path = $request->file('training_certificate')->store('uploads/certificates', 'public');
        
    }

    return response()->json(['message' => 'Academic info submitted successfully!']);
}
}