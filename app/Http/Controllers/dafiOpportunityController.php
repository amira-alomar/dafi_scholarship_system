<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;
use App\Models\UserOpportunity;
use Illuminate\Http\Request;
use App\Models\StudentInfo;

class DafiOpportunityController extends Controller
{
public function index()
{
    $user = Auth::user();

    if ($user->studentInfo && $user->studentInfo->idScholarship) {
        $scholarshipId = $user->studentInfo->idScholarship;
$scholarship = \App\Models\Scholarship::find($scholarshipId);
    
//   $opportunities = Opportunity::with('scholarships')->get();
  if ($scholarship) {
            $opportunities = $scholarship->opportunities;
        foreach ($opportunities as $opportunity) {
            $opportunity->type = strtolower(trim($opportunity->type));
        }

        return view('student.dafi_opp', compact('opportunities'));
    }

    return view('student.dafi_opp', ['opportunities' => []]);
}
}

}




