<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Opportunity;
use App\Models\UserOpportunity;
use App\Models\AcademicGoal;
use App\Models\Training;
use App\Models\volunteering;
use App\Models\StudentInfo;
use App\Models\Course;
use App\Models\Skill;
use App\Models\UserSkills;
use App\Models\JobOpportunity;
use App\Models\SavedJob;
use App\Models\club;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
        public function index()
    {
        $user = auth()->user();
         $userId = Auth::id();
        $applications = $user->appliedOpportunities()
                         ->orderByPivot('application_date', 'desc')
                         ->get();
        $userSkills = auth()->user()->userSkills;
        $courses = Course::where('idUser', Auth::id())->get();
        $studentInfo = auth()->user()->studentInfo;
        $studentInfoID = $studentInfo->studentInfoID ?? null;
        $totalVolunteeringHours = $studentInfo?->volunteerings()?->sum('total_hours') ?? 0;
        $totalTrainings = $studentInfo?->trainings()?->count() ?? 0;
       
        $major = $user->major ?? null;
        $goals = AcademicGoal::where('studentInfoID', $studentInfoID)->get();


        $currentCourses = $courses->filter(function ($course) {
            return $course->grade === null; // مثلاً: إذا ما في درجة بعد = كورس حالي
        });
        $completedCourses = $courses->filter(function ($course) {
            return $course->grade !== null; // الكورسات اللي فيها درجات = مكتملة
        });
        $userSkills = $user->skills->pluck('skillID')->toArray();

        $jobs = JobOpportunity::with('skills')->get()->map(function ($job) use ($userSkills) {
        $jobSkillIds = $job->skills->pluck('skillID')->toArray();
        $matchingSkills = array_intersect($userSkills, $jobSkillIds);

        $job->match_count = count($matchingSkills);
        $job->total_skills = count($jobSkillIds);
        $job->match_percent = $job->total_skills > 0
            ? round((count($matchingSkills) / $job->total_skills) * 100)
            : 0;

                return $job;
            })->filter(function ($job) {
                return $job->match_count > 0;
            });
        $dashboardClubs = $user->clubs()
        ->withPivot('status')
        ->get();

             // نفرض أن السميستر الحالي هو السنة الميلادية الحالية
    $currentYear = Carbon::now()->year;

    // نجلب كل الكورسات لهذا المستخدم لهذا العام
    $allThisYear = Course::where('idUser', $userId)
                         ->whereYear('created_at', $currentYear)
                         ->orderBy('created_at', 'desc');

    // نأخذ أول 4 للعرض في الداشبورد
    $dashboardCourses = $allThisYear->take(4)->get();

    // نحسب كم تبقى من كورسات لهذا العام
    $remainingCount = max(0, $allThisYear->count() - $dashboardCourses->count());
 // نفرض أن السميستر الحالي هو السنة الميلادية الحالية
    $currentYear = Carbon::now()->year;

    // نجلب كل الكورسات لهذا المستخدم لهذا العام
    $allThisYear = Course::where('idUser', $userId)
                         ->whereYear('created_at', $currentYear)
                         ->orderBy('created_at', 'desc');

    // نأخذ أول 4 للعرض في الداشبورد
    $dashboardCourses = $allThisYear->take(4)->get();

    // نحسب كم تبقى من كورسات لهذا العام
    $remainingCount = max(0, $allThisYear->count() - $dashboardCourses->count());


        
        return view('student.dashboard', [
            'allSkills' => Skill::all(),
            'userSkills' => $userSkills,
            'goals' => $goals,
            'dashboardClubs' => $dashboardClubs,
            'jobs' => $jobs,
            'dashboardCourses' => $dashboardCourses,
            'remainingCount' => $remainingCount,
            'applications' => $applications,
            'currentCourses' => $currentCourses,
            'completedCourses' => $completedCourses,
            'totalTrainings' => $totalTrainings,
            'volunteeringHours' => $totalVolunteeringHours,
            'major' => optional($studentInfo)->major,
            'gpa' => optional($studentInfo)->gpa,
            'year' => optional($studentInfo)->year,
            'image' => optional($studentInfo)->image,
            'universityID' => optional($studentInfo)->universityID,
            'expected_graduation' => optional($studentInfo)->expected_graduation,
            'university' => optional($studentInfo->university)->name ?? null,
            'scholarship' => optional($studentInfo->scholarship)->name ?? null,
           
        ]);
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
}
