<?php

namespace App\Http\Controllers;

use App\Models\Volunteering;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteeringController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_hours' => 'required|string|max:255',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $studentInfo = StudentInfo::where('idUser', Auth::id())->first();

        if (!$studentInfo) {
            return response()->json(['error' => 'Student information not found. Please complete your academic profile first.'], 400);
        }

        $path = null;
        if ($request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('certificates/volunteerings', 'public');
        }

        Volunteering::create([
            'name' => $request->name,
            'total_hours' => $request->total_hours,
            'certificate' => $path,
            'studentInfoID' => $studentInfo->studentInfoID,
        ]);

        return response()->json(['message' => 'Volunteering uploaded successfully!']);
    }
}
