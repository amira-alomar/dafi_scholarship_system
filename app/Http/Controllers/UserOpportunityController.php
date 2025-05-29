<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;

use App\Models\Opportunity;
use App\Models\UserOpportunity;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo;

class UserOpportunityController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email',
            'opportunity_title' => 'required|string',
            'status'       => 'required|string',
        ]);

        $user = Auth::user();
        $opportunity = Opportunity::where('title', $data['opportunity_title'])->firstOrFail();

        // تحقق إذا سبق وقدم
        if (UserOpportunity::where('idUser', $user->id)
            ->where('idOpportunity', $opportunity->opportunityID)
            ->exists()
        ) {
            return back()->with('error', 'You have already applied for this opportunity.');
        }

        UserOpportunity::create([
            'idUser'           => $user->id,
            'idOpportunity'    => $opportunity->opportunityID,
            'application_date' => now(),
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }
    public function index()
    {
        $applications = UserOpportunity::with(['user', 'opportunity'])->get();
        return view('admin.appliedForOpp', compact('applications'));
    }

    public function accept($idUser, $idOpportunity)
    {
        UserOpportunity::where('idUser', $idUser)
            ->where('idOpportunity', $idOpportunity)
            ->update(['status' => 'accepted']);

        return back()->with('success', 'Application accepted!');
    }

    public function reject($idUser, $idOpportunity)
    {
        UserOpportunity::where('idUser', $idUser)
            ->where('idOpportunity', $idOpportunity)
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Application rejected!');
    }
    public function showStudentProfile($idUser)
    {
        // eager‑load the related User and any other relations you need
        $studentInfo = StudentInfo::with('user')
                        ->where('idUser', $idUser)
                        ->firstOrFail();

        return view('admin.studentProfile', compact('studentInfo'));
    }
}
