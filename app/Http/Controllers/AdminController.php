<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Scholarship;
use App\Models\AdminScholarship; // هو نفسه جدول admin_scholarships

class AdminController extends Controller
{

   public function manage()
{
    $admins      = Admin::all();
    $supervisors = Admin::where('role', 'supervisor')->get();
    $scholarships = Scholarship::all();
    $assignments = AdminScholarship::with('admin', 'scholarship')->get(); // العنتريات

    return view('admin.manage', compact('admins', 'supervisors', 'scholarships', 'assignments'));
}


    public function store(Request $request)
    {

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'phone'    => 'nullable|string',
            'address'  => 'nullable|string',
            'role'     => 'required|in:admin,supervisor',
        ]);
         
        $data['password'] = bcrypt($data['password']);
        Admin::create($data);

        return redirect()->route('admins.manage')
            ->with('success', 'Admin created successfully!');
    }

    public function assign(Request $request)
    {
        $request->validate([
            'supervisor_id'  => 'required|exists:admins,id',
            'scholarship_id' => 'required|exists:scholarships,scholarshipID',
        ]);

        AdminScholarship::create([
            'admin_id'       => $request->supervisor_id,
            'idScholarship'  => $request->scholarship_id,
        ]);

        return redirect()->route('admins.manage')
            ->with('success', 'Supervisor assigned successfully!');
    }
}
