<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequiredDocument;
use App\Models\Scholarship;

class RequiredDocumentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:pdf,image',
            'idScholarship' => 'required|exists:scholarships,scholarshipID',
        ]);

        RequiredDocument::create($data);

        return back()->with('success', 'Document added successfully!');
    }

    public function update(Request $request, $id)
    {
        $doc = RequiredDocument::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:pdf,image',
        ]);

        $doc->update($data);

        return back()->with('success', 'Document updated successfully!');
    }

    public function destroy($id)
    {
        $doc = RequiredDocument::findOrFail($id);
        $doc->delete();

        return back()->with('success', 'Document deleted successfully!');
    }
}

