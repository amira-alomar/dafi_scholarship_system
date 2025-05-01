<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo;

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
        if (!$studentInfo) {
            return response()->json(['error' => 'Student info not found. Please complete your academic info first.'], 400);
        }
        $path = null;
        if ($request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('certificates', 'public');
        }

        Training::create([
            'name' => $request->name,
            'certificate' => $path,
            'studentInfoID' => $studentInfo->studentInfoID,
        ]);

        return response()->json(['message' => 'Training uploaded successfully!']);
    }
}

