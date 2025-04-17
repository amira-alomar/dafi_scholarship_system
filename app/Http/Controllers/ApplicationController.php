<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\AdminScholarship;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        $adminId = Auth::guard('admin')->id();
        // Get all scholarships this admin is responsible for
        $scholarshipIds = AdminScholarship::where('admin_id', $adminId)
            ->pluck('idScholarship');
        // Get all applications for these scholarships
        $applications = Application::whereIn('idScholarship', $scholarshipIds)
            ->with(['user', 'scholarship'])
            ->get();
        return view('supervisor.application', compact('applications'));
    }
    public function showApplicationDetails($applicationID)
    {
        $application = Application::with(['applicationForm', 'answers.question', 'documents'])
            ->where('applicationID', $applicationID)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found');
        }

        return view('supervisor.applicationDetails', compact('application'));
    }
    public function approveApplication($applicationID)
    {
        // Fetch the application form associated with the applicationID
        $applicationForm = \App\Models\ApplicationForm::where('applicationFormID', $applicationID)->first();

        // Ensure the application form exists
        if (!$applicationForm) {
            return redirect()->back()->with('error', 'Application form not found');
        }

        // Update the status to "Accepted"
        $applicationForm->status = 'approved';
        $applicationForm->save();

        // Redirect with a success message
        return redirect()->route('supervisor.application')->with('success', 'Application has been accepted');
    }

    public function rejectApplication($applicationID)
    {
        // Fetch the application form associated with the applicationID
        $applicationForm = \App\Models\ApplicationForm::where('applicationFormID', $applicationID)->first();

        // Ensure the application form exists
        if (!$applicationForm) {
            return redirect()->back()->with('error', 'Application form not found');
        }

        // Update the status to "Rejected"
        $applicationForm->status = 'rejected';
        $applicationForm->save();

        // Redirect with a success message
        return redirect()->route('supervisor.application')->with('success', 'Application has been rejected');
    }
    public function acceptedStudents()
    {
        $adminId = Auth::guard('admin')->id();
        // Get all scholarships this admin is responsible for
        $scholarshipIds = AdminScholarship::where('admin_id', $adminId)
            ->pluck('idScholarship');
        // Get all applications for these scholarships
        $applications = Application::whereIn('idScholarship', $scholarshipIds)
            ->where('status', 'approved')
            ->with(['user', 'scholarship','user.studentInfo'])
            ->get();
        return view('supervisor.acceptedStudents', compact('applications'));
    }
}
