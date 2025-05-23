<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidiateDashController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OppController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\ManageScholarshipController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\DafiOpportunityController;
use App\Http\Controllers\AcadmicController;
use App\Http\Controllers\UserOpportunityController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\VolunteeringController;
use App\Http\Controllers\AcademicGoalController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ScholarshipMentorController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\RequiredDocumentController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\JobOpportunity;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\GraduateFeedbackController;




Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/', [CandidiateDashController::class, "welcome"])
    ->name('welcome');
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

//Auth controller
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Logout Route
});


//Admin
Route::middleware([AdminMiddleware::class])->group(function () {
    //Admin
    // Route::get('/admin/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');
    Route::get('/admin/opp', [OppController::class, "index"])
        ->name('admin.opp');
    Route::post('/opportunities/store', [OppController::class, 'store'])
        ->name('opportunities.store');
    Route::put('/opportunities/{opportunityID}', [OppController::class, 'update'])
        ->name('opportunities.update');
    Route::delete('/opportunities/{opportunityID}', [OppController::class, 'destroy'])
        ->name('opportunities.destroy');
    Route::get('/admin/AllUser', [AllUserController::class, "AllUser"])
        ->name('admin.user');
    Route::get('/admin/university', [UniversityController::class, "index"])
        ->name('admin.uni');
    Route::put('/admin/universities/{universityID}', [UniversityController::class, 'update'])
        ->name('universities.update');
    Route::post('/admin/universities', [UniversityController::class, 'store'])
        ->name('universities.store');
    Route::delete('/admin/universities/{universityID}', [UniversityController::class, 'destroy'])
        ->name('universities.destroy');
    //faqs
    Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    //
    Route::get('admin/scholarships', [ManageScholarshipController::class, 'index'])->name('scholarships.index');
    Route::post('admin/scholarships', [ManageScholarshipController::class, 'store'])->name('scholarships.store');
    Route::delete('admin/scholarships/{id}', [ManageScholarshipController::class, 'destroy'])->name('scholarships.destroy');
    Route::put('admin/scholarships/{id}', [ManageScholarshipController::class, 'update'])->name('scholarships.update');
    // Criteria
    Route::post('/criteria/{scholarship}/add', [ManageScholarshipController::class, 'addCriteria'])->name('criteria.add');
    Route::delete('/criteria/{id}', [ManageScholarshipController::class, 'deleteCriteria'])->name('criteria.delete');

    // Benefit
    Route::post('/benefits/{scholarship}/add', [ManageScholarshipController::class, 'addBenefit'])->name('benefit.add');
    Route::delete('/benefits/{id}', [ManageScholarshipController::class, 'deleteBenefit'])->name('benefit.delete');

    // Partner
    Route::post('/partners/{scholarship}/add', [ManageScholarshipController::class, 'addPartner'])->name('partner.add');
    Route::delete('/partners/{scholarship}/{partner}', [ManageScholarshipController::class, 'deletePartner'])->name('partner.delete');

    Route::get('/admin/jobsOpp', [JobOpportunityController::class, 'display'])->name('admin.jobOpp');
    Route::put('/admin/jobs/{jobID}', [JobOpportunityController::class, 'update'])->name('admin.jobs.update');
    Route::delete('/admin/jobs/{jobID}', [JobOpportunityController::class, 'destroy'])->name('admin.jobs.destroy');
    Route::post('/admin/jobs/store', [JobOpportunityController::class, 'store'])->name('admin.jobs.store');

    Route::get('/admin/partners', [PartnerController::class, 'index'])->name('admin.partners');
    Route::get('/admin/partners/create', [PartnerController::class, 'create'])->name('partners.create');
    Route::post('/admin/partners', [PartnerController::class, 'store'])->name('partners.store');
    Route::get('/admin/partners/{id}/edit', [PartnerController::class, 'edit'])->name('partners.edit');
    Route::put('/admin/partners/{id}', [PartnerController::class, 'update'])->name('partners.update');
    Route::delete('/admin/partners/{id}', [PartnerController::class, 'destroy'])->name('partners.destroy');

    // Admins management
    Route::get('/admins/manage', [AdminController::class, 'manage'])
        ->name('admins.manage');
    Route::post('/admins/store', [AdminController::class, 'store'])
        ->name('admins.store');
    Route::post('/admins/assign', [AdminController::class, 'assign'])
        ->name('admins.assign');
    Route::put('/admins/{admin}',    [AdminController::class, 'update'])
        ->name('admins.update');
    Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])
        ->name('admins.destroy');
    Route::put('/assignments/{assignment}', [AdminController::class, 'updateAssignment'])
        ->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AdminController::class, 'destroyAssignment'])
        ->name('assignments.destroy');
    //
    Route::get('/applications', [UserOpportunityController::class, 'index'])->name('applications.index');
    Route::post('/applications/{idUser}/{idOpportunity}/accept', [UserOpportunityController::class, 'accept'])->name('applications.accept');
    Route::post('/applications/{idUser}/{idOpportunity}/reject', [UserOpportunityController::class, 'reject'])->name('applications.reject');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
    // Route::get('/club', function () {
    //     return view('admin.club');
    // })->name('club');
    // List all clubs (and optionally filter by club_id if passed)
    Route::get('/admin/clubs', [ClubController::class, 'listClubs'])
        ->name('admin.clubs.list');

    // Show create‐club form is part of the same view; submission:
    Route::post('/admin/clubs', [ClubController::class, 'storeClub'])
        ->name('admin.clubs.store');

    // Fetch one club’s data (for edit modal or detail view via AJAX)
    Route::get('/admin/clubs/{club}/fetch', [ClubController::class, 'fetchClub'])
        ->name('admin.clubs.fetch');

    // Update an existing club
    Route::patch('/admin/clubs/{club}', [ClubController::class, 'updateClub'])
        ->name('admin.clubs.update');

    // Delete a club (AJAX or form)
    Route::delete('/admin/clubs/{club}', [ClubController::class, 'removeClub'])
        ->name('admin.clubs.remove');

    // Show members & requests for one club (if you render a members section server‐side)
    Route::get('/admin/clubs/{club}/members', [ClubController::class, 'showMembers'])
        ->name('admin.clubs.members');

    // Accept a pending membership
    Route::post('/admin/clubs/members/accept/{member}', [ClubController::class, 'acceptMember'])
        ->name('admin.clubs.members.accept');

    // Reject a pending membership
    Route::post('/admin/clubs/members/reject/{member}', [ClubController::class, 'rejectMember'])
        ->name('admin.clubs.members.reject');


    // Add application stage
    Route::post('/scholarship/{id}/stages', [ManageScholarshipController::class, 'AddStage'])->name('stage.add');

    // Delete application stage
    Route::delete('/stages/{id}', [ManageScholarshipController::class, 'DeleteStage'])->name('stage.delete');
    //=====================================================================================

    //supervisor
    Route::get('/supervisor/scholarship/{scholarshipID}/users', [AllUserController::class, 'manageUsers'])
        ->name('supervisor.manageUsers');

    // Route::get('/supervisor/scholarships', function () {
    //     return view('supervisor.manageScholarship');
    // })->name('supervisor.dashboard');

    Route::get('/supervisor/scholarship/{scholarshipID}', [ScholarshipController::class, 'manageScholarship'])
        ->name('supervisor.manageScholarship');

    Route::put('/supervisor/users/update-status/{id}', [AllUserController::class, 'updateUserStatus'])
        ->name('updateUserStatus');

    Route::get('/supervisor/scholarship', [ScholarshipController::class, 'scholarshipOfEachSupervisor'])
        ->name('supervisor.dashboard');

    Route::get('/supervisor/acceptedStudents/{scholarshipID}', [ApplicationController::class, 'acceptedStudents'])
        ->name('supervisor.acceptedStudents');

    //     Route::get('/supervisor/courses', [CourseController::class, 'index'])
    //     ->name('supervisor.course');
    // Route::delete('/courses/{id}', [CourseController::class, 'destroy'])
    //     ->name('courses.destroy');

    Route::get('/supervisor/courses/{scholarshipID}', [CourseController::class, 'index'])
        ->name('supervisor.course');

    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])
        ->name('courses.destroy');

    Route::get('/questions/{scholarshipId}', [QuestionController::class, 'index'])
        ->name('supervisor.questions');
    //documents
    // Document routes
    Route::post('/documents', [RequiredDocumentController::class, 'store'])->name('documents.store');
    Route::put('/documents/{id}', [RequiredDocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{id}', [RequiredDocumentController::class, 'destroy'])->name('documents.destroy');
    //=====================================
    Route::prefix('supervisor')->name('supervisor.')->group(function () {
        Route::get('final-application/{scholarshipID}', [ApplicationController::class, 'finalApplication'])
            ->name('finalApplication');

        Route::post('final-application/{scholarshipID}', [ApplicationController::class, 'storeFinalApplication'])
            ->name('finalApplication.store');
    });
    Route::post(
        '/application/approve/{applicationID}',
        [ApplicationController::class, 'approveFinalApplication']
    )->name('finalApplication.approve');

    Route::post(
        '/application/reject/{applicationID}',
        [ApplicationController::class, 'rejectFinalApplication']
    )->name('finalApplication.reject');


    // Applications list per scholarship
    Route::get('/supervisor/{scholarshipId}/applications', [ApplicationController::class, 'index'])
        ->name('supervisor.application');

    // Application details (ما ضروري تضيف scholarshipId هون إذا كان applicationID كافي، بس للاتساق ممكن تحطيه)
    Route::get('/supervisor/{scholarshipId}/application/{applicationID}', [ApplicationController::class, 'showApplicationDetails'])
        ->name('supervisor.applicationDetails');

    //add notes

    Route::post('/supervisor/final-application/{scholarshipID}/add-note', [ApplicationController::class, 'addNote'])->name('supervisor.addNote');
    //interview
    Route::prefix('supervisor')->group(function () {

        Route::get('/{scholarshipID}/interview', [InterviewController::class, 'showEligibleForInterview'])
            ->name('supervisor.interview');

        Route::get('/interview-details/{studentID}', [InterviewController::class, 'showInterviewDetails'])
            ->name('interview.details');
        Route::post('/interview/accept/{studentID}', [InterviewController::class, 'acceptInterview'])
            ->name('interview.accept');

        Route::post('/interview/reject/{studentID}', [InterviewController::class, 'rejectInterview'])
            ->name('interview.reject');

        //d
        Route::post('/interview/schedule/{applicationID}', [InterviewController::class, 'scheduleInterview'])
            ->name('interview.schedule');
        Route::post('/interview/{studentID}/complete', [InterviewController::class, 'completeInterview'])
            ->name('interview.complete');

        Route::post('/interview/{studentID}/cancel', [InterviewController::class, 'cancelInterview'])
            ->name('interview.cancel');
    });
    Route::get('/supervisor/{scholarshipID}/exam', [ScholarshipController::class, 'showEligibleForExam'])
        ->name('supervisor.exam');
    Route::get('/exam-details/{studentID}', [ScholarshipController::class, 'showExamDetails'])
        ->name('exam.details');
    Route::post('/exam/{studentID}/approve', [ScholarshipController::class, 'approveStudent'])
        ->name('exam.approve');
    Route::post('/exam/{studentID}/reject', [ScholarshipController::class, 'rejectStudent'])
        ->name('exam.reject');
    Route::post('/exam/send-invitation/{applicationID}', [ScholarshipController::class, 'sendInvitation'])
        ->name('exam.sendInvitation');

    // Approve and reject routes with scholarshipId
    Route::post('/supervisor/{scholarshipId}/application/approve/{applicationID}', [ApplicationController::class, 'approveApplication'])
        ->name('application.approve');
// routes/web.php
Route::post(
    '/supervisor/scholarship/{scholarshipId}/end-form',
    [ApplicationController::class, 'endFormStage']
)->name('supervisor.endFormStage');
//
Route::post(
    '/supervisor/scholarship/{scholarshipID}/end-interview',
    [InterviewController::class, 'endInterviewStage']
)->name('supervisor.endInterviewStage');
//
Route::post(
    '/supervisor/scholarship/{scholarshipID}/end-exam',
    [ExamController::class, 'endExamStage']
)->name('supervisor.endExamStage');
//
    Route::post('/supervisor/{scholarshipId}/application/reject/{applicationID}', [ApplicationController::class, 'rejectApplication'])
        ->name('application.reject');
    //exam result
    Route::get('exam-results/create/{scholarshipID}', [ExamController::class, 'create'])
        ->name('examResult.create');

    // Handle form submission
    Route::post('exam-results/store/{scholarshipID}', [ExamController::class, 'store'])
        ->name('examResult.store');

    // interview result
    Route::get('interview-results/create/{scholarshipID}', [InterviewController::class, 'create'])
        ->name('interviewResult.create');

    Route::post('interview-results/store/{scholarshipID}', [InterviewController::class, 'store'])
        ->name('interviewResult.store');
});
// Student
Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    Route::get('/jobs', [JobOpportunityController::class, 'index']);
    Route::post('/jobs/{id}/save', [JobOpportunityController::class, 'saveJob'])->name('jobs.save');
    Route::get('/acadmic', [AcadmicController::class, 'index'])->name('student.acadmic');
    Route::get('/acadmic/goals', [AcademicGoalController::class, 'index'])->name('goals.index');
    Route::get('/goals', [AcademicGoalController::class, 'index'])->name('goals.index');
    Route::post('/goals', [AcademicGoalController::class, 'store'])->name('goals.store');
    Route::put('/goals/{id}', [AcademicGoalController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{id}', [AcademicGoalController::class, 'destroy'])->name('goals.destroy');
    Route::post('/acadmic/store', [AcadmicController::class, 'store'])->name('student.acadmic.store');
    Route::get('/dafi_opp', [DafiOpportunityController::class, 'index']);
    Route::post('/trainings', [TrainingController::class, 'store'])->name('trainings.store');
    Route::post('/volunteerings', [VolunteeringController::class, 'store'])->name('volunteerings.store');
    Route::get('/courses',    [CoursesController::class, 'index'])->name('courses.index');
    Route::post('/courses/store', [CoursesController::class, 'store'])->name('courses.store');
    Route::put('/courses/{course}',  [CoursesController::class, 'update'])->name('courses.update');
    Route::get('/courses/{course}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::get('/student/profile', [StudentProfileController::class, 'index'])->name('student.profile');
    Route::put('/student/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
    Route::post('/profile/skills/add', [StudentProfileController::class, 'addSkill'])->name('profile.skills.add');
    Route::post('/applications', [UserOpportunityController::class, 'store'])->name('applications.store');
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::post('/dashboard/{id}/save', [StudentDashboardController::class, 'saveJob'])->name('dashboard.save');

    Route::get('/student/clubs', [ClubController::class, 'index'])->name('student.clubs');
    Route::get('/student/clubs/{club}', [ClubController::class, 'show'])
        ->name('student.clubs.show');
    Route::post('/graduate/feedback', [GraduateFeedbackController::class, 'store'])
        ->name('graduate.feedback.store');
    Route::post('/student/clubs/join', [ClubController::class, 'join'])
        ->name('student.clubs.join');



    //================================================================================================
});


//Candidate
Route::middleware(['auth', 'role:Candidate'])->group(function () {
    Route::get('/candidate/dashboard', [CandidiateDashController::class, "index"])
        ->name('candidate.dashboard');
    Route::get('/scholarship/{id}', [ScholarshipController::class, 'show'])
        ->name('scholarship_details');
    Route::get('/track_your_application', [CandidiateDashController::class, 'Track'])
        ->name('track_your_application');
    Route::get('/apply/{scholarship}', [CandidiateDashController::class, 'apply'])
        ->name('apply');
    Route::post('/scholarships/{scholarshipID}/apply', [ApplicationController::class, 'apply'])
        ->name('scholarship.apply');
    Route::get('/candidate/submitted', [ApplicationController::class, 'submitted'])
        ->name('candidate.submitted');
    Route::get('/profile', [CandidiateDashController::class, 'show'])
        ->name('profile.show');
    Route::put('/profile', [CandidiateDashController::class, 'update'])
        ->name('profile.update');
});

//questions
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');

//documents
Route::get('/download-document/{path}', function ($path) {
    $path = str_replace('..', '', $path);
    $fullPath = storage_path('app/private/documents/' . $path);

    if (!file_exists($fullPath)) {
        abort(404, 'File not found');
    }
    return response()->download($fullPath);
})->name('download.document');


Route::get('/view-document/{path}', function ($path) {
    $path = str_replace('..', '', $path);
    $fullPath = storage_path('app/private/documents/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->name('download.document.view');

//progile image
Route::get('/profile-picture/{filename}', function ($filename) {
    $path = 'private/documents/' . $filename;

    if (!Storage::exists($path)) {
        abort(404);
    }

    $file = Storage::get($path);
    $type = Storage::mimeType($path);

    return response($file)->header('Content-Type', $type);
})->name('profile.picture');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/partner-image/{filename}', function ($filename) {
    $path = storage_path('app/partners/' . $filename);
    if (!File::exists($path)) abort(404);
    return response()->file($path);
})->name('partner.image');


Route::get('/partner-picture/{filename}', function ($filename) {
    $path = 'partners/' . $filename;        // storage/app/partners/xxx.png
    if (!Storage::exists($path)) abort(404);
    $file = Storage::get($path);
    $type = Storage::mimeType($path);
    return response($file)->header('Content-Type', $type);
})->name('partner.picture');


Route::get('/opportunity-photo/{filename}', function ($filename) {
    $path = 'opportunities/' . $filename;
    if (! Storage::exists($path)) {
        abort(404);
    }
    $file = Storage::get($path);
    $type = Storage::mimeType($path);
    return response($file)->header('Content-Type', $type);
})->name('opportunity.photo');

Route::match(['get', 'post'], '/mentor', [ScholarshipMentorController::class, 'analyze'])->name('mentor.mentor');
