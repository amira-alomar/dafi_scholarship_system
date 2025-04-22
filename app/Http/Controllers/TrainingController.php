<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo;

class TrainingController extends Controller
{
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
            'student_info_id' => $studentInfo->studentInfoID,
        ]);

        return response()->json(['message' => 'Training uploaded successfully!']);
    }
}

