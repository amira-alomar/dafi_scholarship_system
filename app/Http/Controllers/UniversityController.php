<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universities = University::all();
        return view('admin.ManageUniversities', compact('universities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function store(Request $request)
    {
        University::create($request->all());
        return redirect()->back()->with('success', 'University added.');
    }
    
    public function update(Request $request, $id)
{
    $university = University::findOrFail($id);
    $university->update($request->all());
    return redirect()->back()->with('success', 'University updated.');
}

public function destroy($id)
{
    $university = University::findOrFail($id);
    $university->delete();
    return redirect()->back()->with('success', 'University deleted.');
}
}
