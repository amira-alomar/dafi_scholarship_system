<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOpportunity;

class JobOpportunityController extends Controller
{
    // 
    public function index()
    {
        $jobs = \App\Models\JobOpportunity::all(); // جلب كل فرص العمل من قاعدة البيانات
        return view('student.job', compact('jobs')); // تمريرهم للـ Blade
    }
    
   

}
