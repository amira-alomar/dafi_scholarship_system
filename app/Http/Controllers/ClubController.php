<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo;
use App\Models\AllUser;
use App\Models\ClubUser;

class ClubController extends Controller
{
    // 1. عرض قائمة الأندية
    public function index(Request $request)
    {
        // 1. أبني الاستعلام مع الفلاتر (search + category)
        $userId = Auth::id();
        $studentInfo = auth()->user()->studentInfo;
        $major =  optional($studentInfo)->major ?? null;
        $query = Club::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 2. أضف withCount لحساب الأعضاء المقبولين
        $clubs = $query->withCount([
            'users as accepted_users_count' => function ($q) {
                // نوضح إننا نعتمد عمود status من جدول club_user
                $q->where('club_user.status', 'accepted');
            }
        ])->get();

        // 3. جلب الفئات للاختيار
        $categories = Club::distinct()->pluck('category');

        // 4. أُرسل البيانات للـ view
        return view('student.clubs', compact('clubs', 'categories', 'major'));
    }

    // 2. تفاصيل نادي محدد (للـ AJAX أو Blade المودال)
    public function show(Club $club)
    {
        return response()->json([
            'club' => $club,
            'members_count' => $club->users()->count(),
        ]);
    }

    // 3. طلب الانضمام

    public function join(Request $request)
    {
        $user = auth()->user();
        $clubId = $request->input('club_id');

        if (!$user || !$clubId) {
            return redirect()->back()->with('error', 'Invalid request.');
        }

        $club = Club::findOrFail($clubId);

        // تحقق إذا كان المستخدم قد انضم مسبقاً
        if ($user->clubs()->where('club_id', $clubId)->exists()) {
            return back()->with('info', 'You have already requested to join this club.');
        }

        // إذا لم ينضم بعد، أضفه
        $user->clubs()->attach($clubId, ['status' => 'pending']);

        return redirect()->back()->with('success', 'Join request sent successfully!');
    }

   public function listClubs(Request $request)
{
    $clubs = Club::withCount([
        'users as members_count' => function ($q) {
            $q->where('club_user.status', 'accepted');
        },
        'users as pending_count' => function ($q) {
            $q->where('club_user.status', 'pending');
        },
    ])->get();

    $members = null;

    if ($request->has('club_id')) {
        $members = ClubUser::with('user')
            ->where('club_id', $request->club_id)
            ->get();
    }
    
    return view('admin.club', compact('clubs', 'members'));
}


    // storeClub: validate and save new club
    public function storeClub(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category'    => 'required|in:art,techno,sports,science,culture',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('partners', $filename, 'local');

            $imagePath = $filename;
        }

        Club::create([
            'name'        => $request->input('name'),
            'category'    => $request->input('category'),
            'description' => $request->input('description'),
            'image'       => $imagePath, // هذا اللي بيحلو المشاكل
        ]);

        return redirect()->route('admin.clubs.list')->with('success', 'New club created!');
    }


   public function fetchClub(Club $club)
{
    // احسب العدّادات لو مش محمولين
    $club->loadCount([
        'users as members_count' => fn($q)=> $q->where('club_user.status','accepted'),
        'users as pending_count' => fn($q)=> $q->where('club_user.status','pending'),
    ]);

    // جيب الأعضاء
    $members = ClubUser::with('user')
        ->where('club_id', $club->id)
        ->get();

    return response()->json([
        'club'    => $club,
        'members' => $members,
    ]);
}


    // updateClub: validate and update existing club
    public function updateClub(Request $request, Club $club)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|string',
            'category'    => 'required|in:art,techno,sports,science,culture',
            'description' => 'nullable|string',
        ]);

        $club->update($request->only([
            'name',
            'image',
            'category',
            'description'
        ]));

        return redirect()->route('admin.clubs.list')
            ->with('success', 'Club updated!');
    }

    // removeClub: delete the club
    public function removeClub(Club $club)
    {
        $club->delete();
        return response()->json(['message' => 'Club deleted!']);
    }

    // public function showMembers(Club $club)
    // {
    //     $members = ClubUser::with('user')
    //         ->where('club_id', $club->id)
    //         ->get();

    //     return view('admin.club', compact('club', 'members'));
    // }

    public function acceptMember($id)
    {
        $member = ClubUser::findOrFail($id);
        $member->update(['status' => 'accepted']);
        return back()->with('success', 'Member accepted.');
    }

    public function rejectMember($id)
    {
        $member = ClubUser::findOrFail($id);
        $member->update(['status' => 'rejected']);
        return back()->with('success', 'Member rejected.');
    }
}
