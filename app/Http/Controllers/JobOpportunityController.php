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
        $alreadySaved = SavedJob::where('user_id', $user->id)
            ->where('job_opportunity_id', $id)
            ->first();

        if (!$alreadySaved) {
            SavedJob::create([
                'user_id' => $user->id,
                'job_opportunity_id' => $id,
            ]);
        }

        return back()->with('success', 'Job saved successfully!');
    }
    public function display()
    {
        $jobs = JobOpportunity::all();
        return view('admin.jobOpp', compact('jobs'));
    }


    public function update(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'details' => 'required|string',
            'application_method' => 'required|string',
            'application_deadline' => 'required|date',
        ]);
    
        // Find the job by ID
        $job = JobOpportunity::findOrFail($id);
    
        // Update fields
        $job->title = $request->input('title');
        $job->company_name = $request->input('company_name');
        $job->location = $request->input('location');
        $job->details = $request->input('details');
        $job->application_method = $request->input('application_method');
        $job->application_deadline = $request->input('application_deadline');
    
        // Save changes
        $job->save();
    
        return redirect()->route('admin.jobOpp')->with('success', 'Job updated successfully.');
    }
    
    public function destroy($id)
    {
        // Find and delete the job
        $job = JobOpportunity::findOrFail($id);
        $job->delete();
    
        return redirect()->route('admin.jobOpp')->with('success', 'Job deleted successfully.');
    }
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'company_name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'details' => 'required|string',
        'application_method' => 'required|string',
        'application_deadline' => 'required|date',
    ]);

    JobOpportunity::create([
        'title' => $request->title,
        'company_name' => $request->company_name,
        'location' => $request->location,
        'details' => $request->details,
        'application_method' => $request->application_method,
        'application_deadline' => $request->application_deadline,
        'posting_date' => now(), // or $request if you allow setting it manually
    ]);

    return redirect()->back()->with('success', 'Job added successfully!');
}

    
}
