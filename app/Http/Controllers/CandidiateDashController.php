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
        $graduatesCount = Graduates::count();
        $scholarships = Scholarship::with(['criteria', 'benefits', 'partners', 'applicationStages', 'countries'])->get();
        return view('welcome', compact('graduatesCount', 'steps', 'graduates', 'FAQs', 'scholarships', 'students', 'scholarshipCount', 'applicationCount'));
    }
    public function track()
    {
        $user = Auth::user();
        $applications = Application::with(['scholarship', 'applicationForm', 'exam', 'interview', 'applicationStages'])
            ->where('idUser', $user->id)
            ->get();

        $selectedApplication = request('selected_application')
            ? $applications->where('applicationID', request('selected_application'))->first()
            : $applications->first();

        return view('candidate.track', compact('applications', 'selectedApplication'));
    }

    public function apply($id)
    {
        $scholarship = Scholarship::with('questions', 'requiredDocuments')->findOrFail($id);
        $hasApplied = false;
        if (Auth::check()) {
            $hasApplied = Application::where('idUser', Auth::id())
                ->where('idScholarship', $scholarship->scholarshipID)
                ->exists();
        }
        return view('candidate.apply', compact('scholarship', 'hasApplied'));
    }

    public function show()
    {
        $user = Auth::user();
        return view('candidate.profile', compact('user'));
    }

    public function update(Request $request)
    {
        // Get the currently authenticated user
        $myuser = Auth::user();

        // Find the user in the all_users table
        $user = AllUser::findOrFail($myuser->id);

        // Validate input data
        $validatedData = $request->validate([
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:all_users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        // If a password is provided, hash it
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); // Don't update the password if not provided
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Generate unique file name 
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Store the file in private/documents
            $path = $file->storeAs('private/documents', $fileName);

            // Save the path (or you can customize it if needed)
            $validatedData['profile_picture'] = $path;
        }

        // Update user
        $user->update($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
