<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\AdminScholarship;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the logged-in admin ID
        $adminId = Auth::guard('admin')->id();

        // Get all scholarship IDs for this admin
        $scholarshipIds = AdminScholarship::where('admin_id', $adminId)
            ->pluck('idScholarship');

        // Get all applications related to the scholarships of the admin
        $applications = Application::whereIn('idScholarship', $scholarshipIds)
            ->with(['user', 'scholarship', 'user.courses'])
            ->get();

        // Return data to the view
        return view('supervisor.course', compact('applications'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->back()->with('success', 'Course dropped successfully!');
    }
}
