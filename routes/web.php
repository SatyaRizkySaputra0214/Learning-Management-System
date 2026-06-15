<?php

use App\Http\Controllers\Settings;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MuridController;
use Illuminate\Support\Facades\Route;

// Home redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Registration (Public)
Route::get('/register', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/register', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/register/success', [RegistrationController::class, 'success'])->name('registration.success');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Debug (for testing)
Route::middleware(['auth'])->get('/debug-user', function() {
    return view('debug-user');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Registrations
    Route::get('/registrations', [AdminController::class, 'registrations'])->name('registrations.index');
    Route::get('/registrations/{registration}', [AdminController::class, 'showRegistration'])->name('registrations.show');
    Route::delete('/registrations/{registration}', [AdminController::class, 'deleteRegistration'])->name('registrations.delete');
    Route::post('/registrations/{registration}/verify', [AdminController::class, 'verifyRegistration'])->name('registrations.verify');
    Route::get('/registrations/{registration}/create-user', [AdminController::class, 'createUserFromRegistration'])->name('registrations.create-user');
    Route::post('/registrations/{registration}/create-user', [AdminController::class, 'storeUserFromRegistration'])->name('registrations.store-user');
    
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/gurus', [AdminController::class, 'gurus'])->name('users.gurus');
    Route::get('/murids', [AdminController::class, 'murids'])->name('users.murids');
    Route::get('/admins', [AdminController::class, 'admins'])->name('users.admins');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Classes
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes.index');
    Route::get('/classes/create', [AdminController::class, 'createClass'])->name('classes.create');
    Route::post('/classes', [AdminController::class, 'storeClass'])->name('classes.store');
    Route::get('/classes/{class}', [AdminController::class, 'showClass'])->name('classes.show');
    Route::get('/classes/{class}/edit', [AdminController::class, 'editClass'])->name('classes.edit');
    Route::put('/classes/{class}', [AdminController::class, 'updateClass'])->name('classes.update');
    Route::post('/classes/enroll', [AdminController::class, 'enrollStudents'])->name('classes.enroll');
    Route::delete('/classes/{class}', [AdminController::class, 'destroyClass'])->name('classes.delete');

    // Monitoring Kelas
    Route::get('/monitoring', [AdminController::class, 'monitoringIndex'])->name('monitoring.index');
    Route::get('/monitoring/{class}/students/{student}', [AdminController::class, 'monitoringStudentDetail'])->name('monitoring.student');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    
    // Classes
    Route::get('/classes', [GuruController::class, 'classes'])->name('classes.index');
    Route::get('/classes/{class}', [GuruController::class, 'showClass'])->name('classes.show');
    
    // Meetings
    Route::get('/classes/{class}/meetings/create', [GuruController::class, 'createMeeting'])->name('meetings.create');
    Route::post('/classes/{class}/meetings', [GuruController::class, 'storeMeeting'])->name('meetings.store');
    Route::get('/meetings/{meeting}/edit', [GuruController::class, 'editMeeting'])->name('meetings.edit');
    Route::put('/meetings/{meeting}', [GuruController::class, 'updateMeeting'])->name('meetings.update');
    Route::delete('/meetings/{meeting}', [GuruController::class, 'deleteMeeting'])->name('meetings.delete');

    // Announcements
    Route::get('/meetings/{meeting}/announcements/create', [GuruController::class, 'createAnnouncement'])->name('announcements.create');
    Route::post('/meetings/{meeting}/announcements', [GuruController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [GuruController::class, 'editAnnouncement'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [GuruController::class, 'updateAnnouncement'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [GuruController::class, 'deleteAnnouncement'])->name('announcements.delete');
    
    // Materials
    Route::get('/meetings/{meeting}/materials/create', [GuruController::class, 'createMaterial'])->name('materials.create');
    Route::post('/meetings/{meeting}/materials', [GuruController::class, 'storeMaterial'])->name('materials.store');
    Route::delete('/materials/{material}', [GuruController::class, 'deleteMaterial'])->name('materials.delete');
    
    // Quizzes
    Route::get('/meetings/{meeting}/quizzes/create', [GuruController::class, 'createQuiz'])->name('quizzes.create');
    Route::post('/meetings/{meeting}/quizzes', [GuruController::class, 'storeQuiz'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [GuruController::class, 'editQuiz'])->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [GuruController::class, 'updateQuiz'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [GuruController::class, 'deleteQuiz'])->name('quizzes.delete');
    Route::get('/quizzes/{quiz}/results', [GuruController::class, 'quizResults'])->name('quizzes.results');
    Route::post('/quizzes/{quiz}/questions', [GuruController::class, 'addQuestion'])->name('questions.add');
    Route::delete('/questions/{question}', [GuruController::class, 'deleteQuestion'])->name('questions.delete');
    Route::get('/questions/{question}/edit', [GuruController::class, 'editQuestion'])->name('questions.edit');
    Route::put('/questions/{question}', [GuruController::class, 'updateQuestion'])->name('questions.update');
    
    // Assignments
    Route::get('/meetings/{meeting}/assignments/create', [GuruController::class, 'createAssignment'])->name('assignments.create');
    Route::get('/meetings/{meeting}/assignments/create-simple', [GuruController::class, 'createAssignmentSimple'])->name('assignments.create-simple');
    Route::post('/meetings/{meeting}/assignments', [GuruController::class, 'storeAssignment'])->name('assignments.store');
    Route::get('/assignments/{assignment}/edit', [GuruController::class, 'editAssignment'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [GuruController::class, 'updateAssignment'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [GuruController::class, 'deleteAssignment'])->name('assignments.delete');
    Route::get('/assignments/{assignment}/submissions', [GuruController::class, 'viewSubmissions'])->name('assignments.submissions');
    Route::post('/submissions/{submission}/grade', [GuruController::class, 'gradeSubmission'])->name('assignments.grade');
    Route::post('/assignments/{assignment}/grade-student', [GuruController::class, 'gradeStudent'])->name('assignments.grade-student');
    Route::get('/submissions/{submission}/file', [GuruController::class, 'viewSubmissionFile'])->name('assignments.file');

    // Attendance
    Route::get('/meetings/{meeting}/attendance', [GuruController::class, 'attendanceIndex'])->name('attendance.index');
    Route::post('/meetings/{meeting}/attendance', [GuruController::class, 'markAttendance'])->name('attendance.mark');
    
    // Certificates
    Route::get('/classes/{class}/certificates', [GuruController::class, 'certificatesIndex'])->name('certificates.index');
    Route::get('/classes/{class}/students/{student}/certificate/generate', [GuruController::class, 'generateCertificate'])->name('certificates.generate');
    Route::post('/classes/{class}/students/{student}/certificate', [GuruController::class, 'storeCertificate'])->name('certificates.store');
    Route::get('/classes/{class}/students/{student}/certificate/view', [GuruController::class, 'viewStudentCertificate'])->name('certificates.view');

    // Grades (Rekap Nilai)
    Route::get('/grades', [GuruController::class, 'selectClassForGrades'])->name('grades.select-class');
    Route::get('/classes/{class}/grades', [GuruController::class, 'gradeSummary'])->name('grades.summary');
    Route::get('/classes/{class}/students/{student}/grades', [GuruController::class, 'studentGrades'])->name('grades.student');
    Route::get('/classes/{class}/grades/export', [GuruController::class, 'exportGrades'])->name('grades.export');

    // Student Detail (Registration Data)
    Route::get('/classes/{class}/students/{student}/detail', [GuruController::class, 'studentDetail'])->name('students.detail');

    // Quiz Results Management
    Route::get('/quiz-results', [GuruController::class, 'selectClassForQuizResults'])->name('quizzes.select-class');
    Route::get('/classes/{class}/quiz-results', [GuruController::class, 'classQuizResults'])->name('quizzes.class-results');
    Route::delete('/quiz-results/{score}/reset', [GuruController::class, 'resetQuizScore'])->name('quizzes.reset');
});

// Murid Routes
Route::middleware(['auth', 'role:murid'])->prefix('murid')->name('murid.')->group(function () {
    Route::get('/dashboard', [MuridController::class, 'dashboard'])->name('dashboard');
    Route::get('/enrolled-classes', [MuridController::class, 'enrolledClasses'])->name('enrolled-classes');
    Route::get('/enrolled-classes/{class}', [MuridController::class, 'showEnrolledClass'])->name('enrolled-classes.show');
    Route::get('/meetings/{meeting}', [MuridController::class, 'viewMeeting'])->name('meeting');
    Route::get('/materials/{material}/download', [MuridController::class, 'downloadMaterial'])->name('material.download');

    // Quizzes
    Route::get('/quizzes/{quiz}/take', [MuridController::class, 'takeQuiz'])->name('quiz.take');
    Route::post('/quizzes/{quiz}/submit', [MuridController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quizzes/{quiz}/deadline', [MuridController::class, 'checkDeadline'])->name('quiz.deadline');
    Route::get('/quiz-scores/{score}', [MuridController::class, 'quizResult'])->name('quiz.result');

    // Assignments
    Route::get('/assignments/{assignment}/submit', [MuridController::class, 'submitAssignment'])->name('assignment.submit');
    Route::post('/assignments/{assignment}/submit', [MuridController::class, 'storeAssignmentSubmission'])->name('assignment.store');
    Route::get('/assignments/{assignment}/review', [MuridController::class, 'reviewAssignment'])->name('assignment.review');
    Route::get('/submissions/{submission}/file', [MuridController::class, 'viewSubmissionFile'])->name('assignment.file');
    Route::delete('/assignments/{assignment}/submission', [MuridController::class, 'destroySubmission'])->name('assignment.delete');

    // Certificates
    Route::get('/certificates', [MuridController::class, 'certificates'])->name('certificates');
    Route::get('/certificates/{certificate}/download', [MuridController::class, 'downloadCertificate'])->name('certificate.download');
    Route::get('/progress-detail', [MuridController::class, 'progressDetail'])->name('progress-detail');

    // Notifications
    Route::post('/notifications/{announcement}/read', [MuridController::class, 'markAnnouncementRead'])->name('notification.read');
});

// Settings (keep existing)
Route::middleware(['auth'])->group(function () {
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
    Route::put('settings/appearance', [Settings\AppearanceController::class, 'update'])->name('settings.appearance.update');
});
