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
        $user = Auth::user();
        $opportunity = Opportunity::where('title', $request->input('opportunity_title'))->first();

        if (!$opportunity) {
            return redirect()->back()->with('error', 'Opportunity not found.');
        }
    
        // 🔍 تحقق إذا المستخدم سبق وقدم على نفس الفرصة
        $alreadyApplied = UserOpportunity::where('idUser', $user->id)
            ->where('idOpportunity', $opportunity->opportunityID)
            ->exists();
    
        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'You have already applied for this opportunity.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'opportunity_title' => 'required|string',
            'motivation' => 'required|string',
        ]);

        $opportunity = Opportunity::where('title', $request->opportunity_title)->first();

        if (!$opportunity) {
            return redirect()->back()->with('error', 'Opportunity not found.');
        }

        UserOpportunity::create([
            'idUser' => Auth::id(),
            'idOpportunity' => $opportunity->opportunityID,
            'application_date' => now(),
            'motivation' => $request->input('motivation'),
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }
}
