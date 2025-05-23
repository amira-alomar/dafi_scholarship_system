<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Scholarship;
use App\Models\AllUser;
use App\Models\University;
use App\Models\Partner;
use App\Models\Club;
use App\Models\JobOpportunity;
use App\Models\AdminScholarship; // هو نفسه جدول admin_scholarships
use Carbon\Carbon;

class AdminController extends Controller
{

    public function manage()
    {
        $admins      = Admin::all();
        $supervisors = Admin::where('role', 'supervisor')->get();
        $scholarships = Scholarship::all();
        $assignments = AdminScholarship::with('admin', 'scholarship')->get(); // العنتريات

        return view('admin.manage', compact('admins', 'supervisors', 'scholarships', 'assignments'));
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'phone'    => 'nullable|string',
            'address'  => 'nullable|string',
            'role'     => 'required|in:admin,supervisor',
        ]);

        $data['password'] = bcrypt($data['password']);
        Admin::create($data);

        return redirect()->route('admins.manage')
            ->with('success', 'Admin created successfully!');
    }

    public function assign(Request $request)
    {
        $request->validate([
            'supervisor_id'  => 'required|exists:admins,id',
            'scholarship_id' => 'required|exists:scholarships,scholarshipID',
        ]);

        $assignment = AdminScholarship::firstOrCreate([
            'admin_id'      => $request->supervisor_id,
            'idScholarship' => $request->scholarship_id,
        ]);
        if (! $assignment->wasRecentlyCreated) {
            return redirect()->route('admins.manage')
                ->with('error', 'This supervisor is already assigned to this scholarship.');
        }

        return redirect()->route('admins.manage')
            ->with('success', 'Supervisor assigned successfully!');
    }
    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:admins,email,' . $admin->id,
            'phone'   => 'nullable|string',
            'address' => 'nullable|string',
            'role'    => 'required|in:admin,supervisor',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        // نرجع JSON لو عملنا AJAX أو نرجع فلاش عادي:
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Updated!'], 200);
        }
        return redirect()->route('admins.manage')->with('success', 'Admin updated successfully!');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.manage')->with('success', 'Admin deleted successfully!');
    }
    public function updateAssignment(Request $request, AdminScholarship $assignment)
    {
        $data = $request->validate([
            'admin_id'        => 'required|exists:admins,id',
            'idScholarship'   => 'required|exists:scholarships,scholarshipID',
        ]);

        $assignment->update($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Assignment updated!'], 200);
        }
        return redirect()->route('admins.manage')
            ->with('success', 'Assignment updated successfully!');
    }

    public function destroyAssignment(AdminScholarship $assignment)
    {
        $assignment->delete();
        return redirect()->route('admins.manage')
            ->with('success', 'Assignment removed successfully!');
    }
    public function dashboard(Request $request)
    {
        // Count ’em up!
        $scholarshipsCount  = Scholarship::count();
        $usersCount         = AllUser::count();
        $universitiesCount  = University::count();
        $partnersCount      = Partner::count();
        $jobsCount          = JobOpportunity::count();

        // Grab the 5 most recent scholarships—fresh off the presses!
        $recentScholarships = Scholarship::orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $activities = collect([
            optional(AllUser::latest()->first())->created_at ? [
                'label' => 'New user registered',
                'name' => AllUser::latest()->first()->name,
                'time' => AllUser::latest()->first()->created_at,
                'type' => 'user',
            ] : null,

            optional(Scholarship::latest()->first())->created_at ? [
                'label' => 'New scholarship added',
                'name' => Scholarship::latest()->first()->title,
                'time' => Scholarship::latest()->first()->created_at,
                'type' => 'scholarship',
            ] : null,

            optional(JobOpportunity::latest()->first())->created_at ? [
                'label' => 'New job opportunity',
                'name' => JobOpportunity::latest()->first()->title,
                'time' => JobOpportunity::latest()->first()->created_at,
                'type' => 'job',
            ] : null,

            optional(Club::latest()->first())->created_at ? [
                'label' => 'New club created',
                'name' => Club::latest()->first()->name,
                'time' => Club::latest()->first()->created_at,
                'type' => 'club',
            ] : null,

            optional(Partner::latest()->first())->created_at ? [
                'label' => 'New partner added',
                'name' => Partner::latest()->first()->name,
                'time' => Partner::latest()->first()->created_at,
                'type' => 'partner',
            ] : null,
        ])
            ->filter()
            ->sortByDesc('time')
            ->values();
            ////////////////////////////////
            // === chart data ===
    $period = (int) $request->query('period', 90);
    $start  = Carbon::today()->subDays($period - 1);

    $labels = collect()
        ->times($period, fn($i) => $start->copy()->addDays($i)->format('Y-m-d'))
        ->toArray();

    $userCounts = AllUser::selectRaw("DATE(created_at) as day, count(*) as cnt")
        ->where('created_at', '>=', $start)
        ->groupBy('day')
        ->pluck('cnt', 'day')
        ->toArray();
    $schCounts  = Scholarship::selectRaw("DATE(created_at) as day, count(*) as cnt")
        ->where('created_at', '>=', $start)
        ->groupBy('day')
        ->pluck('cnt', 'day')
        ->toArray();

    $usersData = array_map(fn($d) => $userCounts[$d] ?? 0, $labels);
    $schsData  = array_map(fn($d) => $schCounts[$d] ?? 0,  $labels);

    return view('admin.dashboard', compact(
        'scholarshipsCount',
        'usersCount',
        'universitiesCount',
        'partnersCount',
        'jobsCount',
        'recentScholarships',
        'activities',
        'labels',
        'usersData',
        'schsData',
        'period'
    ));
        
    }
    //   public function applicationsOverTime(Request $request)
    // {
    //     // determine period in days from query string, default 90
    //     $period = (int) $request->query('period', 90);
    //     $start  = Carbon::today()->subDays($period - 1);

    //     // build array of dates: ['2025-02-16', ..., '2025-05-16']
    //     $labels = collect()
    //         ->times($period, fn($i) => $start->copy()->addDays($i)->format('Y-m-d'))
    //         ->toArray();

    //     // counts per day
    //     $userCounts = AllUser::selectRaw("DATE(created_at) as day, count(*) as cnt")
    //         ->where('created_at', '>=', $start)
    //         ->groupBy('day')
    //         ->pluck('cnt', 'day')
    //         ->toArray();

    //     $schCounts = Scholarship::selectRaw("DATE(created_at) as day, count(*) as cnt")
    //         ->where('created_at', '>=', $start)
    //         ->groupBy('day')
    //         ->pluck('cnt', 'day')
    //         ->toArray();

    //     // align counts to every date label
    //     $usersData = array_map(fn($d) => $userCounts[$d] ?? 0, $labels);
    //     $schsData  = array_map(fn($d) => $schCounts[$d] ?? 0,  $labels);

    //     // pass everything to Blade
    //     return view('admin.dashboard', compact(
    //         'labels',
    //         'usersData',
    //         'schsData',
    //         'period'
    //     ));
    // }
}
