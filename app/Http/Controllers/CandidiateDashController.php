<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\AllUser;
use App\Models\Faq;
use App\Models\Graduates;
use App\Models\Question;
use App\Models\ApplicationStage;

class CandidiateDashController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $scholarshipCount = Scholarship::count();
        $applicationCount = Application::count();
        $scholarships = Scholarship::all();
        $applicationUsers = Application::with('scholarship')
            ->where('idUser', $user->id)
            ->get();
        return view('candidate.dashboard', compact('user', 'scholarshipCount', 'applicationCount', 'scholarships', 'applicationUsers'));
    }

    public function Welcome()
    {
        $students = AllUser::where('role_id', 2)->count();
        $scholarshipCount = Scholarship::count();
        $applicationCount = Application::count();
        $FAQs = Faq::All();
        $lastScholarshipId = ApplicationStage::orderBy('created_at', 'desc')->value('idScholarship');
        $steps = ApplicationStage::where('idScholarship', $lastScholarshipId)
            ->orderBy('order')
            ->get();
        $graduates = Graduates::with('user')->limit(3)->get();
        $scholarships = Scholarship::with(['criteria', 'benefits', 'partners', 'applicationStages'])->get();
        return view('welcome', compact('steps', 'graduates', 'FAQs', 'scholarships', 'students', 'scholarshipCount', 'applicationCount'));
    }
    public function track()
    {
        $user = Auth::user();
        $applications = Application::with(['scholarship', 'applicationForm', 'exam', 'interview', 'applicationStages'])
            ->where('idUser', $user->id)
            ->get();

        return view('candidate.track', compact('applications'));
    }

    public function apply($id)
    {
        $scholarship = Scholarship::with('questions')->findOrFail($id);
        return view('candidate.apply', compact('scholarship'));
    }
}
