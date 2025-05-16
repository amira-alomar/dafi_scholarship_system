<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Scholarship;
use App\Models\RequiredDocument;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($scholarshipId)
    {
        $scholarship = Scholarship::findOrFail($scholarshipId);
        $questions = Question::where('idScholarship', $scholarshipId)->get();
        $documents = RequiredDocument::where('idScholarship', $scholarshipId)->get();
        return view('supervisor.questions', compact('questions', 'documents', 'scholarship'));
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
        $request->validate([
            'question_text' => 'required',
            'question_type' => 'required',
            'idScholarship' => 'required|exists:scholarships,scholarshipID',
        ]);
        Question::create([
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'idScholarship' => $request->idScholarship,
        ]);
        return redirect()->back()->with('success', 'Question added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $question = Question::findOrFail($id);
        $question->update([
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
        ]);

        return redirect()->back()->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully!');
    }
}
