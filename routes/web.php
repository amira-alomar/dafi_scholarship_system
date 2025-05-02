<?php
use App\Http\Controllers\AllUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidiateDashController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OppController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\TrainingController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\DafiOpportunityController;
use App\Http\Controllers\AcadmicController;
use App\Http\Controllers\UserOpportunityController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\VolunteeringController;
use App\Http\Controllers\AcademicGoalController;






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
});


//Admin
Route::middleware([AdminMiddleware::class])->group(function () {
    //Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
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

    //supervisor
    Route::get('/supervisor/manage_user', [AllUserController::class, "index"])
        ->name('supervisor.user');
    Route::get('/supervisor/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('supervisor.dashboard');
    Route::put('/supervisor/users/update-status/{id}', [AllUserController::class, 'updateUserStatus'])
        ->name('updateUserStatus');
    Route::get('/supervisor/scholarship', [ScholarshipController::class, 'scholarshipOfEachSupervisor'])
        ->name('supervisor.scholarship');
    Route::get('/questions/{scholarshipId}', [QuestionController::class, 'index'])
        ->name('supervisor.questions');
    Route::get('/supervisor/studentInfo', [AllUserController::class, 'getStudentInfo'])
        ->name('supervisor.studentInfo');
    Route::get('/supervisor/courses', [CourseController::class, 'index'])
        ->name('supervisor.course');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])
        ->name('courses.destroy');
    Route::get('/supervisor/applications', [ApplicationController::class, 'index'])
        ->name('supervisor.application');
    Route::get('/application/{applicationID}', [ApplicationController::class, 'showApplicationDetails'])
        ->name('supervisor.applicationDetails');
    Route::get('/supervisor/acceptedStudents', [ApplicationController::class, 'acceptedStudents'])
        ->name('supervisor.acceptedStudents');
    //application
    Route::post('/application/approve/{applicationID}', [ApplicationController::class, 'approveApplication'])->name('application.approve');
    Route::post('/application/reject/{applicationID}', [ApplicationController::class, 'rejectApplication'])->name('application.reject');
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
    Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
    
    Route::get('/profile', function () {
        return view('student.profile');
    });
    Route::post('/applications', [UserOpportunityController::class, 'store'])->name('applications.store');

    


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
});

//questions
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
