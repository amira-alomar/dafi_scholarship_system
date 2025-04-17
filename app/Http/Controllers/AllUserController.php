<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Admin;
use App\Models\Application;
use App\Models\AdminScholarship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllUserController extends Controller
{
    public function index()
{
    $supervisor = Auth::guard('admin')->user();
    $scholarships = $supervisor->scholarships;
    $scholarshipApplications = [];
    foreach ($scholarships as $scholarship) {
        $applications = Application::with('user.role') 
            ->where('idScholarship', $scholarship->scholarshipID)
            ->get();
        $scholarshipApplications[] = [
            'scholarship' => $scholarship,
            'applications' => $applications
        ];
    }
    return view('supervisor.ManageUsers', compact('scholarshipApplications'));
}


    public function updateUserStatus(Request $request, $id)
    {
        $user = AllUser::findOrFail($id);
        $user->status = $request->has('status') ? 'active' : 'inactive'; // Check if status is present, else set to 0
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }
    public function getStudentInfo()
    {
        // Get the logged-in admin ID
    $adminId = Auth::guard('admin')->id();

    // Get all scholarship IDs for this admin
    $scholarshipIds = AdminScholarship::where('admin_id', $adminId)
        ->pluck('idScholarship'); 

    // Get all applications related to the scholarships of the admin
    $applications = Application::whereIn('idScholarship', $scholarshipIds)
        ->with(['user.studentInfo', 'scholarship'])
        ->get();

    // Return data to the view
    return view('supervisor.studentInfo', compact('applications'));
    }
    
    public function AllUser(){
        $users = AllUser::all();
        return view('admin.user', compact('users'));
    }

}
