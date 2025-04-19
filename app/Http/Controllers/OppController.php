<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opps=Opportunity::all();
        return view('admin.opp',compact('opps'));
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
        'title' => 'required|string|max:255',
        'type' => 'required|string',
        'status' => 'required|string',
        'date' => 'required|date',
        'description' => 'required|string',
        'location' => 'required|string',
    ]);

    Opportunity::create($request->all());

    return redirect()->route('admin.opp')->with('success', 'Opportunity added successfully!');
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
    $opp = Opportunity::findOrFail($id);

    $opp->update($request->only('title', 'type', 'status', 'date', 'location', 'description'));

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
