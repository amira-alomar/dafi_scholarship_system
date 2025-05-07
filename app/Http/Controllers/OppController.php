<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opps = Opportunity::with('scholarships')->get();
        $scholarships = Scholarship::all();
        return view('admin.opp', compact('opps', 'scholarships'));
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
        $data = $request->validate([
            'title'       => 'required|string',
            'type'        => 'required|string',
            'status'      => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string',
            'description' => 'required|string',
            'scholarships' => 'required|array',
            'photo'       => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('photo')) {
            // store the photo in storage and save the path
            $data['photo'] = $request->file('photo')->store('opportunities');
        }

        $opp = Opportunity::create($data);
        $opp->scholarships()->sync($data['scholarships']);

        return redirect()->route('admin.opp')
            ->with('success', 'Opportunity created!');
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
    public function update(Request $request, $id)
{
    $request->validate([
        'title'        => 'required|string|max:255',
        'type'         => 'required|string',
        'status'       => 'required|string',
        'date'         => 'required|date',
        'description'  => 'required|string',
        'location'     => 'required|string',
        'scholarships' => 'required|array',
        'scholarships.*' => 'exists:scholarships,scholarshipID',
        'photo'        => 'nullable|image|max:4096',
    ]);

    $opp = Opportunity::findOrFail($id);
    $opp->update($request->only('title', 'type', 'status', 'date', 'description', 'location'));

    // Update the pivot table with new scholarships
    $opp->scholarships()->sync($request->scholarships);

    // Check if a new photo was uploaded
    if ($request->hasFile('photo')) {
        // Delete old photo if it exists
        if ($opp->photo) {
            Storage::delete($opp->photo);
        }
        // Store the new photo and update the opportunity record
        $opp->photo = $request->file('photo')->store('opportunities');
        $opp->save();  // Don't forget to save the updated photo
    }

    return redirect()->back()->with('success', 'Opportunity updated!');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Opportunity::findOrFail($id)->delete();
        return redirect()->back();
    }
}
