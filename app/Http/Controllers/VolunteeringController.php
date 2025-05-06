<?php

namespace App\Http\Controllers;

use App\Models\Volunteering;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteeringController extends Controller
{

    public function index()
    {
        
        return view('student.acadmic', compact('volunteering'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_hours' => 'required|string|max:50',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $studentInfo = StudentInfo::where('idUser', Auth::id())->first(); 

        $path = null;
        if ($request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('certificates', 'public');
        }

        Volunteering::create([
            'name' => $request->name,
            'total_hours' => $request->total_hours,
            'certificate' => $path,
            'studentInfoID' => $studentInfo->studentInfoID,
        ]);

        return redirect()->back()->with('success', 'Volunteering uploaded successfully!');
    }
}
