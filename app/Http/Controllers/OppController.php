<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class OppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opps = Opportunity::with('scholarships')->get();
        $scholarships = Scholarship::all();
        return view('admin.opp', compact('opps','scholarships'));
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
        'title'        => 'required|string|max:255',
        'type'         => 'required|string',
        'status'       => 'required|string',
        'date'         => 'required|date',
        'description'  => 'required|string',
        'location'     => 'required|string',
        'scholarships' => 'required|array',
        'scholarships.*' => 'exists:scholarships,scholarshipID',
    ]);

    $opp = Opportunity::create($request->only('title','type','status','date','description','location'));

    // اربط المنح
    $opp->scholarships()->attach($request->scholarships);

    return redirect()->route('admin.opp')->with('success','Opportunity added successfully!');
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
        ]);
    
        $opp = Opportunity::findOrFail($id);
        $opp->update($request->only('title','type','status','date','description','location'));
    
        // حدّث الـ pivot بالمنح الجديدة
        $opp->scholarships()->sync($request->scholarships);
    
        return redirect()->back()->with('success','Opportunity updated!');
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
