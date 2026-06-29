<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatMonitoringController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchedulingController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsTeacher;
use App\Http\Middleware\IsStudent;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\StudentManagementController;
use App\Http\Controllers\Teacher\AnalyticsController;
use App\Http\Controllers\Teacher\ClassMaterialController;
use App\Http\Controllers\Teacher\ClassOverviewController;
use App\Http\Controllers\Teacher\GradingController;
use App\Http\Controllers\Teacher\ChatController;
use App\Http\Controllers\Teacher\SettingsController as TeacherSettingsController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ELearningController;
use App\Http\Controllers\Student\ClassController as StudentClassController;
use App\Http\Controllers\Student\ProgressController;
use App\Http\Controllers\Student\ChatController as StudentChatController;
use App\Http\Controllers\Student\CertificateController;
use App\Http\Controllers\Student\SettingsController as StudentSettingsController;
use App\Http\Controllers\Admin\CourseController;

// Landing Page
Route::get('/', function () {
    $courses = \App\Models\Course::where('status', 'active')->orderBy('price')->get();
    return view('landing', compact('courses'));
})->name('landing');

Route::get('/landing', function () {
    $courses = \App\Models\Course::where('status', 'active')->orderBy('price')->get();
    return view('landing', compact('courses'));
});

// Language Switcher
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('locale.switch');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::post('/forgot-password/check-email', [AuthController::class, 'forgotPasswordCheckEmail'])->name('forgot-password.check-email');
Route::post('/forgot-password/verify-answer', [AuthController::class, 'forgotPasswordVerifyAnswer'])->name('forgot-password.verify-answer');
Route::post('/forgot-password/reset', [AuthController::class, 'forgotPasswordReset'])->name('forgot-password.reset');

// Admin Routes - Protected with Auth + IsAdmin Middleware + ReadOnlyOwner
Route::prefix('admin')->middleware(['auth', IsAdmin::class, \App\Http\Middleware\ReadOnlyOwner::class])->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    // Payments
    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('admin.payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');
    Route::get('/payments/students', [PaymentController::class, 'getStudents'])->name('admin.payments.students');
    Route::get('/payments/classes', [PaymentController::class, 'getClasses'])->name('admin.payments.classes');
    Route::post('/payments/invoice/create', [PaymentController::class, 'createInvoice'])->name('admin.payments.invoice.create');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verifyPayment'])->name('admin.payments.verify');
    Route::post('/installments/{installment}/verify', [PaymentController::class, 'verifyInstallment'])->name('admin.installments.verify');
    Route::get('/payments/pending/verification', [PaymentController::class, 'getPendingVerification'])->name('admin.payments.pending');
    
    // Invoices are removed since they are merged into payments
    
    // Chat Monitoring
    Route::get('/chat-monitoring', [ChatMonitoringController::class, 'index'])->name('admin.chat-monitoring');
    Route::get('/chat-monitoring/{conversation}/messages', [ChatMonitoringController::class, 'getMessages'])->name('admin.chat-monitoring.messages');


    
    // Students
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::put('/students/{user}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/students/{user}', [StudentController::class, 'destroy'])->name('admin.students.destroy');
    Route::get('/users/{user}/logs', [AdminController::class, 'getUserLogs'])->name('admin.users.logs');
    
    // Teachers
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('admin.teachers.store');
    Route::put('/teachers/{user}', [TeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/teachers/{user}', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy');
    
    // Scheduling
    Route::get('/scheduling', [AdminController::class, 'scheduling'])->name('admin.scheduling');
    Route::post('/scheduling', [SchedulingController::class, 'store'])->name('admin.scheduling.store');
    Route::put('/scheduling/{schoolClass}', [SchedulingController::class, 'update'])->name('admin.scheduling.update');
    Route::delete('/scheduling/{schoolClass}', [SchedulingController::class, 'destroy'])->name('admin.scheduling.destroy');
    Route::get('/scheduling/courses', [SchedulingController::class, 'getCourses'])->name('admin.scheduling.courses');
    Route::get('/scheduling/teachers', [SchedulingController::class, 'getTeachers'])->name('admin.scheduling.teachers');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings/profile', [AdminController::class, 'updateProfile'])
    ->name('admin.settings.profile');

    Route::post('/settings/password', [AdminController::class, 'updatePassword'])
    ->name('admin.settings.password');

    // Online Meetings
    Route::get('/meetings', [App\Http\Controllers\Admin\OnlineMeetingController::class, 'index'])->name('admin.meetings');
    Route::put('/meetings/{meeting}', [App\Http\Controllers\Admin\OnlineMeetingController::class, 'update'])->name('admin.meetings.update');
    Route::delete('/meetings/{meeting}', [App\Http\Controllers\Admin\OnlineMeetingController::class, 'destroy'])->name('admin.meetings.destroy');

    // Attendance
    Route::get('/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.attendance');
    Route::get('/attendance/{class}', [App\Http\Controllers\Admin\AttendanceController::class, 'show'])->name('admin.attendance.show');
    Route::put('/attendance/{attendance}/update', [App\Http\Controllers\Admin\AttendanceController::class, 'update'])->name('admin.attendance.update');
    Route::delete('/attendance/{attendance}', [App\Http\Controllers\Admin\AttendanceController::class, 'destroy'])->name('admin.attendance.destroy');




    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');
    Route::post('/reports/generate', [App\Http\Controllers\Admin\ReportController::class, 'generate'])->name('admin.reports.generate');

    // Certificates
    Route::get('/certificates', [App\Http\Controllers\Admin\CertificateController::class, 'index'])->name('admin.certificates');
    Route::post('/certificates', [App\Http\Controllers\Admin\CertificateController::class, 'store'])->name('admin.certificates.store');
    Route::post('/certificates/{certificate}/revoke', [App\Http\Controllers\Admin\CertificateController::class, 'revoke'])->name('admin.certificates.revoke');
    Route::delete('/certificates/{certificate}', [App\Http\Controllers\Admin\CertificateController::class, 'destroy'])->name('admin.certificates.destroy');

    // Teacher Attendance Management
    Route::get('/teacher-attendance', [App\Http\Controllers\Admin\TeacherAttendanceController::class, 'index'])->name('admin.teacher-attendance.index');
    Route::post('/teacher-attendance/schedule', [App\Http\Controllers\Admin\TeacherAttendanceController::class, 'storeSchedule'])->name('admin.teacher-attendance.schedule.store');
    Route::put('/teacher-attendance/schedule/{setting}', [App\Http\Controllers\Admin\TeacherAttendanceController::class, 'updateSchedule'])->name('admin.teacher-attendance.schedule.update');
    Route::delete('/teacher-attendance/schedule/{setting}', [App\Http\Controllers\Admin\TeacherAttendanceController::class, 'destroySchedule'])->name('admin.teacher-attendance.schedule.destroy');
    
    // Courses (Pricing Packages)
    Route::resource('courses', CourseController::class)->names('admin.courses');
});

// Teacher Routes - Protected with Auth + IsTeacher Middleware
Route::prefix('teacher')->middleware(['auth', IsTeacher::class])->group(function () {
    // Dashboard
    Route::get('/', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::post('/dashboard/class/{class}/gmeet', [TeacherDashboardController::class, 'updateGmeet'])->name('teacher.dashboard.gmeet');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('teacher.analytics');
    
    // Classes & Materials
    Route::get('/classes', [ClassMaterialController::class, 'index'])->name('teacher.classes');
    Route::get('/classes/{schoolClass}/overview', [ClassOverviewController::class, 'show'])->name('teacher.classes.show');
    Route::post('/classes/{schoolClass}/announce', [ClassOverviewController::class, 'announce'])->name('teacher.classes.announce');
    Route::post('/materials', [ClassMaterialController::class, 'store'])->name('teacher.materials.store');
    Route::put('/materials/{material}', [ClassMaterialController::class, 'update'])->name('teacher.materials.update');
    Route::delete('/materials/{material}', [ClassMaterialController::class, 'destroy'])->name('teacher.materials.destroy');
    
    // Grading
    Route::get('/grading', [GradingController::class, 'index'])->name('teacher.grading');
    Route::post('/grading', [GradingController::class, 'store'])->name('teacher.grading.store');
    Route::post('/grading/{grade}/publish', [GradingController::class, 'publish'])->name('teacher.grading.publish');
    Route::post('/grading/{grade}/unpublish', [GradingController::class, 'unpublish'])->name('teacher.grading.unpublish');
    
    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('teacher.chat');
    Route::get('/chat/{conversationId}/view', [ChatController::class, 'view'])->name('teacher.chat.view');
    Route::get('/chat/{conversationId}/messages', [ChatController::class, 'getMessages'])->name('teacher.chat.messages');
    Route::post('/chat/{conversationId}/send', [ChatController::class, 'sendMessage'])->name('teacher.chat.send');
    Route::post('/chat/start', [ChatController::class, 'startConversation'])->name('teacher.chat.start');
    Route::get('/chat/students/available', [ChatController::class, 'getAvailableStudents'])->name('teacher.chat.available-students');
    
    // Student Management
    Route::get('/students', [StudentManagementController::class, 'index'])->name('teacher.students.index');
    Route::get('/students/{user}', [StudentManagementController::class, 'show'])->name('teacher.students.show');
    Route::post('/students/{user}/notes', [StudentManagementController::class, 'storeNote'])->name('teacher.students.notes.store');
    Route::post('/students/{user}/calculate-grades', [StudentManagementController::class, 'calculateGrades'])->name('teacher.students.calculate-grades');
    
    // Settings
    Route::get('/settings', [TeacherSettingsController::class, 'index'])->name('teacher.settings');
    Route::post('/settings/security-question', [TeacherSettingsController::class, 'updateSecurityQuestion'])->name('teacher.settings.security-question');
    Route::post('/settings/profile', [TeacherSettingsController::class, 'updateProfile'])->name('teacher.settings.profile');
    Route::post('/settings/password', [TeacherSettingsController::class, 'updatePassword'])->name('teacher.settings.password');
    Route::post('/settings/avatar', [TeacherSettingsController::class, 'uploadAvatar'])->name('teacher.settings.avatar');

    // Online Meetings
    Route::resource('meetings', App\Http\Controllers\Teacher\OnlineMeetingController::class)->names('teacher.meetings');
    Route::post('/meetings/{meeting}/publish', [App\Http\Controllers\Teacher\OnlineMeetingController::class, 'publish'])->name('teacher.meetings.publish');

    // Attendance
    Route::resource('attendance', App\Http\Controllers\Teacher\AttendanceController::class)->parameters(['attendance' => 'session'])->names('teacher.attendance');
    Route::post('/attendance/{session}/publish', [App\Http\Controllers\Teacher\AttendanceController::class, 'publish'])->name('teacher.attendance.publish');
    Route::post('/attendance/{session}/toggle-open', [App\Http\Controllers\Teacher\AttendanceController::class, 'toggleOpen'])->name('teacher.attendance.toggle-open');
    Route::post('/attendance/{session}/update-student', [App\Http\Controllers\Teacher\AttendanceController::class, 'updateStudentAttendance'])->name('teacher.attendance.update-student');
    Route::get('/attendance-report', [App\Http\Controllers\Teacher\AttendanceController::class, 'report'])->name('teacher.attendance.report');

    // Weeks
    Route::post('/weeks', [App\Http\Controllers\Teacher\WeekController::class, 'store'])->name('teacher.weeks.store');
    Route::put('/weeks/{week}', [App\Http\Controllers\Teacher\WeekController::class, 'update'])->name('teacher.weeks.update');
    Route::delete('/weeks/{week}', [App\Http\Controllers\Teacher\WeekController::class, 'destroy'])->name('teacher.weeks.destroy');

    // Assignments (merged into Assessments - redirect for backward compatibility)
    Route::get('/assignments', function() { return redirect()->route('teacher.assessments.index'); })->name('teacher.assignments.index');
    Route::get('/assignments/create', function() { return redirect()->route('teacher.assessments.create'); })->name('teacher.assignments.create');

    // Assessments
    Route::resource('assessments', App\Http\Controllers\Teacher\AssessmentController::class)->names('teacher.assessments');
    Route::post('/assessments/{assessment}/toggle-status', [App\Http\Controllers\Teacher\AssessmentController::class, 'toggleStatus'])->name('teacher.assessments.toggle-status');
    Route::post('/assessments/{assessment}/toggle-open', [App\Http\Controllers\Teacher\AssessmentController::class, 'toggleOpen'])->name('teacher.assessments.toggle_open');
    Route::get('/assessments/{assessment}/submissions', [App\Http\Controllers\Teacher\AssessmentController::class, 'submissions'])->name('teacher.assessments.submissions');
    Route::post('/assessment-submissions/{submission}/grade', [App\Http\Controllers\Teacher\AssessmentController::class, 'gradeSubmission'])->name('teacher.assessments.grade');
    Route::post('/assessments/{assessment}/manual-grade', [App\Http\Controllers\Teacher\AssessmentController::class, 'storeManualGrade'])->name('teacher.assessments.manual-grade');

    // Teacher Attendance (own attendance)
    Route::get('/teacher-attendance', [App\Http\Controllers\Teacher\TeacherAttendanceController::class, 'index'])->name('teacher.teacher-attendance.index');
    Route::post('/teacher-attendance/check-in', [App\Http\Controllers\Teacher\TeacherAttendanceController::class, 'checkIn'])->name('teacher.teacher-attendance.checkin');
    Route::post('/teacher-attendance/check-out', [App\Http\Controllers\Teacher\TeacherAttendanceController::class, 'checkOut'])->name('teacher.teacher-attendance.checkout');
});

// Student Routes - Protected with Auth + IsStudent Middleware
Route::prefix('student')->middleware(['auth', IsStudent::class])->group(function () {
    // Class Selection (No middleware - must be accessible before class selection)
    Route::get('/select-class', [StudentDashboardController::class, 'selectClass'])->name('student.select.class');
    Route::post('/select-class', [StudentDashboardController::class, 'confirmClassSelection'])->name('student.select.class.confirm');
    Route::get('/payment-options/{classId}', [StudentDashboardController::class, 'paymentOptions'])->name('student.payment.options');
    Route::post('/payment-options/{classId}', [StudentDashboardController::class, 'processPayment'])->name('student.payment.process');
    Route::post('/select-class-again', [StudentDashboardController::class, 'selectClassAgain'])->name('student.select.class.again');
    
    // Protected routes (Dashboard & Settings accessible in all stages)
    Route::get('/', [StudentDashboardController::class, 'index'])->name('student.dashboard');


    // Settings
    Route::get('/settings', [StudentSettingsController::class, 'index'])->name('student.settings');
    Route::post('/settings/profile', [StudentSettingsController::class, 'updateProfile'])->name('student.settings.profile');
    Route::post('/settings/password', [StudentSettingsController::class, 'updatePassword'])->name('student.settings.password');
    Route::post('/settings/avatar', [StudentSettingsController::class, 'uploadAvatar'])->name('student.settings.avatar');
    Route::post('/settings/security-question', [StudentSettingsController::class, 'updateSecurityQuestion'])->name('student.settings.security-question');
    Route::post('/settings/language', [StudentSettingsController::class, 'updateLanguage'])->name('student.settings.language');
    
    // Routes requiring at least Class Selection (Stage 2+)
    Route::middleware(['class.selected'])->group(function () {
        Route::get('/payments', [StudentDashboardController::class, 'payments'])->name('student.payments');
        Route::post('/payments/{payment}/upload-proof', [PaymentController::class, 'uploadProof'])->name('student.payments.upload');
        Route::post('/installments/{installment}/upload-proof', [PaymentController::class, 'uploadInstallmentProof'])->name('student.installments.upload');
        
        // Routes requiring FULL Access / Verified Payment (Stage 4)
        Route::middleware(['payment.verified'])->group(function () {
            // E-Learning Hub
            Route::get('/elearning', [ELearningController::class, 'index'])->name('student.elearning');
            Route::get('/elearning/{material}', [ELearningController::class, 'show'])->name('student.elearning.material');
            Route::get('/elearning/{material}/download', [ELearningController::class, 'download'])->name('student.elearning.download');
            
            // Active Classes
            Route::get('/classes', [StudentClassController::class, 'index'])->name('student.classes');
            Route::get('/classes/{class}', [StudentClassController::class, 'show'])->name('student.classes.show');
            Route::get('/classes/{class}/join', [StudentClassController::class, 'joinOnlineClass'])->name('student.classes.join');
            
            // Online Meetings
            Route::get('/meetings', [StudentClassController::class, 'meetings'])->name('student.meetings');
            
            // Progress & Grades
            Route::get('/progress', [ProgressController::class, 'index'])->name('student.progress');
            Route::get('/progress/grades', [ProgressController::class, 'grades'])->name('student.progress.grades');
            Route::get('/progress/skills', [ProgressController::class, 'skillProgress'])->name('student.progress.skills');
            
            // Chat
            Route::get('/chat', [StudentChatController::class, 'index'])->name('student.chat');
            Route::get('/chat/{conversationId}/view', [StudentChatController::class, 'view'])->name('student.chat.view');
            Route::get('/chat/{conversationId}/messages', [StudentChatController::class, 'getMessages'])->name('student.chat.messages');
            Route::post('/chat/{conversationId}/send', [StudentChatController::class, 'sendMessage'])->name('student.chat.send');
            Route::post('/chat/start', [StudentChatController::class, 'startConversation'])->name('student.chat.start');
            Route::get('/chat/teachers/available', [StudentChatController::class, 'getAvailableTeachers'])->name('student.chat.available-teachers');

            // Certificates
            Route::get('/certificates', [CertificateController::class, 'index'])->name('student.certificates');
            Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('student.certificates.show');
            Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('student.certificates.download');

            // Attendance
            Route::get('/attendance', [App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('student.attendance.index');
            Route::post('/attendance/{session}/mark', [App\Http\Controllers\Student\AttendanceController::class, 'mark'])->name('student.attendance.mark');

            // Assignments (merged into Assessments)
            Route::get('/assignments', function() { return redirect()->route('student.assessments.index'); })->name('student.assignments.index');

            // Assessments
            Route::get('/assessments', [App\Http\Controllers\Student\AssessmentController::class, 'index'])->name('student.assessments.index');
            Route::get('/assessments/{assessment}', [App\Http\Controllers\Student\AssessmentController::class, 'show'])->name('student.assessments.show');
            Route::post('/assessments/{assessment}/submit', [App\Http\Controllers\Student\AssessmentController::class, 'submit'])->name('student.assessments.submit');
        });
    });
});

// Public Certificate Verification
Route::get('/verify-certificate/{token}', [CertificateController::class, 'verify'])->name('verify.certificate');