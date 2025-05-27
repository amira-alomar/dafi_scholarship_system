<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Opportunity;
use App\Models\AcademicGoal;
use App\Models\Training;
use App\Models\volunteering;
use App\Models\StudentInfo;
use App\Models\Course;
use App\Models\Skill;
use App\Models\UserSkills;
use App\Models\SavedJob;
use App\Models\JobOpportunity;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentProfileController extends Controller
{
    public function index()
    {
        

        $userSkills = auth()->user()->userSkills;
        $courses = Course::where('idUser', Auth::id())->get();
        $studentInfo = auth()->user()->studentInfo;
        $studentInfoID = $studentInfo->studentInfoID ?? null;
        $totalVolunteeringHours = $studentInfo?->volunteerings()?->sum('total_hours') ?? 0;
        $totalTrainings = $studentInfo?->trainings()?->count() ?? 0;
        $user = auth()->user();
        $major = $user->major ?? null;

        $currentCourses = $courses->filter(function ($course) {
            return $course->grade === null; // مثلاً: إذا ما في درجة بعد = كورس حالي
        });
        $completedCourses = $courses->filter(function ($course) {
            return $course->grade !== null; // الكورسات اللي فيها درجات = مكتملة
        });
        $userSkillsjob = $user->skills->pluck('skillID')->toArray();
        $savedJobIds = SavedJob::where('user_id', $user->id)
                              ->pluck('job_opportunity_id')
                              ->toArray();
         $savedJobs = JobOpportunity::whereIn('jobID', $savedJobIds)->get()->map(function ($job) use ($userSkillsjob) {
            // extract this job’s skill IDs to a plain array
            $jobSkillIds = $job->skills->pluck('skillID')->toArray();

            // intersect two arrays
            $matchingSkills = array_intersect($userSkillsjob, $jobSkillIds);

            // assign back onto *this* $job, not $savedJobs
            $job->match_count   = count($matchingSkills);
            $job->total_skills  = count($jobSkillIds);
            $job->match_percent = $job->total_skills
                ? round((count($matchingSkills) / $job->total_skills) * 100)
                : 0;

            return $job;
        });
                              
        
        return view('student.profile', [
            'allSkills' => Skill::all(),
            'userSkills' => $userSkills,
            'savedJobs' => $savedJobs,
            'currentCourses' => $currentCourses,
            'completedCourses' => $completedCourses,
            'totalTrainings' => $totalTrainings,
            'volunteeringHours' => $totalVolunteeringHours,
            'major' => optional($studentInfo)->major,
            'gpa' => optional($studentInfo)->gpa,
            'year' => optional($studentInfo)->year,
            'universityID' => optional($studentInfo)->universityID,
            'expected_graduation' => optional($studentInfo)->expected_graduation,
            'university'   => data_get($studentInfo, 'university.name', 'Not Set'),
            'scholarship'  => data_get($studentInfo, 'scholarship.name', 'Not Set'),

           
        ]);
    }
    
    public function update(Request $request) {
       

        $user = auth()->user();
        $studentInfo = auth()->user()->studentInfo;
        if (!$studentInfo) {
            // أنشئ سجل جديد إذا مش موجود
            $studentInfo = new StudentInfo();
            $studentInfo->idUser = $user->id;
        }
            // التحقق إذا البيانات المرسلة هي فقط معلومات شخصية
    if ($request->hasAny(['birthdate', 'phone_number', 'address'])) {
        $request->validate([
            'birthdate' => 'nullable|date',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only(['birthdate', 'phone_number', 'address']));
    }
        // التحقق إذا البيانات المرسلة فيها معلومات أكاديمية
        if ($request->hasAny(['gpa', 'expected_graduation', 'major', 'year','universityID'])) {
            $request->validate([
                'gpa' => 'nullable|numeric|min:0|max:4',
                'expected_graduation' => 'nullable|date_format:Y-m',
                'major' => 'nullable|string',
                'year' => 'nullable|string',
                'universityID' => 'nullable|string',
            ]);
    
            $studentInfo->gpa = $request->input('gpa', $studentInfo->gpa);
            
            $expectedMonth = $request->input('expected_graduation');
            if ($expectedMonth) {
                $studentInfo->expected_graduation= $expectedMonth . '-01'; // لتحويل Y-m إلى تاريخ صالح
            }
    
            $studentInfo->major = $request->input('major', $studentInfo->major);
            $studentInfo->year = $request->input('year', $studentInfo->year);
            $studentInfo->universityID = $request->input('universityID', $studentInfo->universityID);
    
            $studentInfo->save();
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_images', $filename, 'public'); // يخزن الصورة في storage/app/public/profile_images
            $user->profile_picture = $filename;
            $user->save(); 
        }
        
    

    
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    public function addSkill(Request $request)
{
    
    $request->validate([
        'name' => 'required|string|max:255',
        'level' => 'required|string|max:50',
    ]);
$user = auth()->user();
    $skill = Skill::where('name', $request->name)->first();
$user->skills()->syncWithoutDetaching([
    $skill->skillID => ['level' => $request->level],
]);

    // ربط المهارة بالمستخدم مع المستوى
    UserSkills::updateOrCreate(
        ['idUser' => auth()->id(), 'idSkill' => $skill->skillID],
        ['level' => $request->level]
    );

    return redirect()->back()->with('success', 'Skill added successfully.');
    
}
}