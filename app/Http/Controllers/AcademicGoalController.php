<?php

namespace App\Http\Controllers;

use App\Models\AcademicGoal;
use App\Models\StudentInfo;
use Illuminate\Http\Request;

class AcademicGoalController extends Controller
{
    public function index()
    {
        $studentInfoID = auth()->user()->studentInfo->studentInfoID;


        $goals = AcademicGoal::where('studentInfoID', $studentInfoID)->get();

        return view('student.acadmic', compact('goals')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        AcademicGoal::create([
            'studentInfoID' => auth()->user()->studentInfo->studentInfoID,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'progress' => 0,
        ]);

        return redirect()->back()->with('success', 'Goal added.');
    }

    public function update(Request $request, $id)
    {
        $goal = AcademicGoal::findOrFail($id);

        $goal->update([
            'progress' => $request->progress,
        ]);

        return redirect()->back()->with('success', 'Progress updated.');
    }

    public function destroy($id)
    {
        AcademicGoal::destroy($id);

        return redirect()->back()->with('success', 'Goal deleted.');
    }
}

