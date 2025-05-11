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
    public function manageUsers($scholarshipID)
    {
        // 1. جيبي المشرف حالياً
        $supervisor = Auth::guard('admin')->user();

        $scholarship = $supervisor->scholarships->where('scholarshipID', $scholarshipID)->first();
        if (!$scholarship) {
            abort(403); // مش من منحته، ممنوع تتفرج
        }


        // 3. جيبي التطبيقات المرتبطة بالمنحة
        $applications = Application::with('user.role')
            ->where('idScholarship', $scholarshipID)
            ->get();

        // 4. ابعتي للـ view
        return view(
            'supervisor.manageUsers',
            compact('scholarship', 'applications')
        );
    }


    public function updateUserStatus(Request $request, $id)
    {
        $user = AllUser::findOrFail($id);
        $user->status = $request->has('status') ? 'active' : 'inactive'; // Check if status is present, else set to 0
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }


    public function AllUser()
    {
        $users = AllUser::all();
        return view('admin.user', compact('users'));
    }
}
