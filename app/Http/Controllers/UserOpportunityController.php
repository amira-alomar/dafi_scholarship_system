<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;

use App\Models\Opportunity;
use App\Models\UserOpportunity;
use Illuminate\Support\Facades\Auth;

class UserOpportunityController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'name'              => 'required|string|max:255',
        'email'             => 'required|email',
        'opportunity_title' => 'required|string',
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

}
