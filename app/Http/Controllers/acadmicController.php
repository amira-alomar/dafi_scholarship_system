<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Opportunity;
use App\Models\UserOpportunity;
use App\Models\Training;
use App\Models\Volunteering;
use App\Models\StudentInfo; 
use Illuminate\Support\Facades\Auth;


class AcadmicController extends Controller{
    public function index()
    {
        $studentInfo = \App\Models\StudentInfo::where('idUser', auth()->id())->first();
        $university = $studentInfo?->university?->name; // لو رابطينها بجامعة
$major = $studentInfo?->major;
$gpa = $studentInfo?->gpa;

    $trainings = [];
    $volunteerings = [];

    if ($studentInfo) {
        $trainings = Training::where('studentInfoID', $studentInfo->studentInfoID)->get();
        $volunteerings = Volunteering::where('studentInfoID', $studentInfo->studentInfoID)->get();
    }

    return view('student.acadmic', compact('university', 'major', 'gpa', 'trainings', 'volunteerings'));
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
            'number_of_training' => 1, // ممكن تعديله حسب عدد المدخلات
            'number_of_volunteering' => 1,
            'idUni' => 1, // بتجيبه حسب الجامعة
        ]
    );

    // تخزين الملفات إذا وُجدت
    if ($request->hasFile('training_certificate')) {
        $path = $request->file('training_certificate')->store('uploads/certificates', 'public');
        // ممكن تحفظ الرابط بالـ DB حسب التصميم
    }

    return response()->json(['message' => 'Academic info submitted successfully!']);
}
}