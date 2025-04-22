<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOpportunity;
use App\Models\SavedJob;
use Illuminate\Support\Facades\Auth;

class JobOpportunityController extends Controller
{
    // 
    public function index()
    {
        $jobs = \App\Models\JobOpportunity::all(); // جلب كل فرص العمل من قاعدة البيانات
        return view('student.job', compact('jobs')); // تمريرهم للـ Blade
    }

public function saveJob($id)
{
    $user = Auth::user();
    

    // تأكدي أنه ما تكون محفوظة من قبل
    $alreadySaved = SavedJob::where('user_id', $user->id )
        ->where('job_opportunity_id', $id)
        ->first();

    if (!$alreadySaved) {
        SavedJob::create([
            'user_id' => $user->id ,
            'job_opportunity_id' => $id,
        ]);
    }

    return back()->with('success', 'Job saved successfully!');
}

}
