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
    $studentInfo = auth()->user()->studentInfo;
    $major =  optional($studentInfo)->major ?? null;
   $scholarshipId = optional($studentInfo)->idScholarship;


    // if ($user->studentInfo && $user->studentInfo->idScholarship) {
        // $scholarshipId = $user->studentInfo->idScholarship;
        if ($scholarshipId) {
              $scholarship = \App\Models\Scholarship::find($scholarshipId);
    
                    if ($scholarship) {
                                $opportunities = $scholarship->opportunities;
                            foreach ($opportunities as $opportunity) {
                                $opportunity->type = strtolower(trim($opportunity->type));
                            }

                            return view('student.dafi_opp', compact('opportunities','major'));
                        }
                    }

       // في حال لم يكن لديه studentInfo أو منحة
    return view('student.dafi_opp', [
        'opportunities' => [],
        'major' => $major,
    ]);
}
}

// }




