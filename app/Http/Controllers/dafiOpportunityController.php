<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;

use Illuminate\Http\Request;

class DafiOpportunityController extends Controller
{
    public function index()
{
    
    $user = Auth::user();

    // نتأكد إن عنده studentInfo و idScholarship
    if ($user->studentInfo && $user->studentInfo->idScholarship) {
        $scholarshipId = $user->studentInfo->idScholarship;

        // نجيب الفرص المرتبطة بهاي المنحة فقط
        $opportunities = Opportunity::where('idScholarship', $scholarshipId)->get();
        foreach ($opportunities as $opportunity) {
            $opportunity->type = strtolower(trim($opportunity->type));
        }

        return view('student.dafi_opp', compact('opportunities'));
    }

    // في حال ما عنده منحة أو بيانات ناقصة
    return view('student.dafi_opp', ['opportunities' => []]);
}
}




