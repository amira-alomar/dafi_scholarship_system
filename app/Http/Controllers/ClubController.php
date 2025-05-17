<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo;
use App\Models\AllUser;

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
        $query->where('name', 'like', '%'.$request->search.'%');
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
    return view('student.clubs', compact('clubs', 'categories','major'));
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



}  