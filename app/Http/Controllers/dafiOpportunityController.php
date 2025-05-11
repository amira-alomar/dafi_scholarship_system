<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;
use App\Models\UserOpportunity;
use Illuminate\Http\Request;

class DafiOpportunityController extends Controller
{
public function index()
{
    $user = Auth::user();

    if ($user->studentInfo && $user->studentInfo->idScholarship) {
        $scholarshipId = $user->studentInfo->idScholarship;

        // استخدم العلاقة بدلاً من where
        $opportunities = \App\Models\Scholarship::find($scholarshipId)
                            ->opportunities()
                            ->get();

        foreach ($opportunities as $opportunity) {
            $opportunity->type = strtolower(trim($opportunity->type));
        }

        return view('student.dafi_opp', compact('opportunities'));
    }

    return view('student.dafi_opp', ['opportunities' => []]);
}

}




