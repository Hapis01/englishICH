<?php

namespace App\Support;

use App\Models\ClassMaterial;
use App\Models\Message;
use App\Models\Payment;
use App\Models\SchoolClass;
use App\Models\StudentGrade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class DashboardNotifications
{
    public static function forAdmin(int $limit = 5): Collection
    {
        $notifications = collect();

        $pendingVerification = Payment::with('user')
            ->where('verification_status', 'pending_verification')
            ->latest()
            ->get();

        if ($pendingVerification->isNotEmpty()) {
            $payment = $pendingVerification->first();
            $notifications->push(self::make(
                'Payment needs verification',
                $pendingVerification->count() . ' payment proof(s) are waiting for admin approval.',
                'warning',
                self::safeRoute('admin.payments'),
                $payment->updated_at ?? $payment->created_at
            ));
        }

        $pendingPayments = Payment::with('user')
            ->where('payment_status', 'pending')
            ->whereDate('due_date', '<=', now()->addDays(7))
            ->orderByRaw('COALESCE(due_date, payment_date) asc')
            ->get();

        if ($pendingPayments->isNotEmpty()) {
            $payment = $pendingPayments->first();
            $notifications->push(self::make(
                'Outstanding student payments',
                $pendingPayments->count() . ' pending invoice(s) are due soon or overdue.',
                'danger',
                self::safeRoute('admin.payments'),
                $payment->due_date ? Carbon::parse($payment->due_date) : ($payment->updated_at ?? $payment->created_at)
            ));
        }

        $recentStudents = User::where('role', 'student')
            ->where('status', 'active')
            ->latest()
            ->take(1)
            ->get();

        if ($recentStudents->isNotEmpty()) {
            $student = $recentStudents->first();
            $notifications->push(self::make(
                'New active student',
                $student->name . ' is registered and active.',
                'success',
                self::safeRoute('admin.students'),
                $student->created_at
            ));
        }

        $activeClasses = SchoolClass::with('teacher')
            ->where('status', 'active')
            ->whereDate('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->get();

        if ($activeClasses->isNotEmpty()) {
            $class = $activeClasses->first();
            $notifications->push(self::make(
                'Upcoming class schedule',
                $class->name . ' starts ' . Carbon::parse($class->start_date)->format('M d') . ' with ' . optional($class->teacher)->name . '.',
                'info',
                self::safeRoute('admin.scheduling'),
                Carbon::parse($class->start_date)
            ));
        }

        $recentMessage = Message::latest()->first();

        if ($recentMessage) {
            $notifications->push(self::make(
                'Chat activity to monitor',
                'Latest teacher-student conversation has new activity.',
                'info',
                self::safeRoute('admin.chat-monitoring'),
                $recentMessage->created_at
            ));
        }

        // Add user database notifications
        $admin = Auth::user();
        if ($admin && $admin->role === 'admin') {
            foreach ($admin->unreadNotifications as $notification) {
                $notifications->push(self::make(
                    $notification->data['title'] ?? 'Notification',
                    $notification->data['message'] ?? '',
                    $notification->data['type'] ?? 'info',
                    $notification->data['action_url'] ?? '#',
                    $notification->created_at
                ));
            }
        }

        return self::sortAndLimit($notifications, $limit);
    }

    public static function forTeacher(User $teacher, int $limit = 5): Collection
    {
        $notifications = collect();

        $classes = SchoolClass::with(['course', 'students'])
            ->where('teacher_id', $teacher->id)
            ->where('status', 'active')
            ->get();

        $unreadMessages = Message::where('receiver_id', $teacher->id)
            ->where('is_read', false)
            ->count();

        if ($unreadMessages > 0) {
            $latestMessage = Message::where('receiver_id', $teacher->id)
                ->where('is_read', false)
                ->latest()
                ->first();

            $notifications->push(self::make(
                'Unread student messages',
                $unreadMessages . ' unread message(s).',
                'danger',
                self::safeRoute('teacher.chat'),
                $latestMessage?->created_at ?? now()
            ));
        }

        $today = now()->format('l');
        $todayClass = $classes->first(fn ($class) => stripos($class->schedule, $today) !== false);
        if ($todayClass) {
            $notifications->push(self::make(
                'Class scheduled today',
                $todayClass->name . ' is scheduled: ' . $todayClass->schedule . '.',
                'info',
                self::safeRoute('teacher.classes'),
                now()
            ));
        }

        $pendingGrades = 0;
        foreach ($classes as $class) {
            $pendingGrades += max(0, $class->students->count() - StudentGrade::where('class_id', $class->id)->where('teacher_id', $teacher->id)->count());
        }

        if ($pendingGrades > 0) {
            $notifications->push(self::make(
                'Grade submission reminder',
                $pendingGrades . ' enrolled student(s) still need grades entered or published.',
                'warning',
                self::safeRoute('teacher.grading'),
                now()->subMinutes(10)
            ));
        }

        $classesWithoutMaterials = $classes->filter(fn ($class) => $class->materials()->count() === 0);
        if ($classesWithoutMaterials->isNotEmpty()) {
            $notifications->push(self::make(
                'Create class materials',
                $classesWithoutMaterials->count() . ' active class(es) do not have learning materials yet.',
                'warning',
                self::safeRoute('teacher.classes'),
                now()->subMinutes(20)
            ));
        }

        // Add user database notifications
        foreach ($teacher->unreadNotifications as $notification) {
            $notifications->push(self::make(
                $notification->data['title'] ?? 'Notification',
                $notification->data['message'] ?? '',
                $notification->data['type'] ?? 'info',
                $notification->data['action_url'] ?? '#',
                $notification->created_at
            ));
        }

        return self::sortAndLimit($notifications, $limit);
    }

    public static function forStudent(User $student, int $limit = 5): Collection
    {
        $notifications = collect();

        $enrolledClasses = $student->enrolledClasses()
            ->where('status', 'active')
            ->with(['course', 'teacher'])
            ->get();

        $today = now()->format('l');
        $todayClass = $enrolledClasses->first(fn ($class) => stripos($class->schedule, $today) !== false);
        if ($todayClass) {
            $notifications->push(self::make(
                'Class scheduled today',
                $todayClass->name . ' with ' . optional($todayClass->teacher)->name . ' at ' . $todayClass->schedule . '.',
                'info',
                self::safeRoute('student.classes'),
                now()
            ));
        }

        $unreadMessages = Message::where('receiver_id', $student->id)
            ->where('is_read', false)
            ->count();

        if ($unreadMessages > 0) {
            $latestMessage = Message::where('receiver_id', $student->id)
                ->where('is_read', false)
                ->latest()
                ->first();

            $notifications->push(self::make(
                'Unread teacher messages',
                $unreadMessages . ' unread message(s).',
                'danger',
                self::safeRoute('student.chat'),
                $latestMessage?->created_at ?? now()
            ));
        }

        $payment = Payment::where('user_id', $student->id)
            ->where('payment_status', 'pending')
            ->orderByRaw('COALESCE(due_date, payment_date) asc')
            ->first();

        if ($payment) {
            $dueText = $payment->due_date ? ' due ' . Carbon::parse($payment->due_date)->format('M d, Y') : ' waiting for payment';
            $notifications->push(self::make(
                'Outstanding payment',
                'Invoice Rp ' . number_format($payment->amount, 0, ',', '.') . $dueText . '.',
                'warning',
                self::safeRoute('student.payments'),
                $payment->due_date ? Carbon::parse($payment->due_date) : ($payment->updated_at ?? $payment->created_at)
            ));
        }

        $classIds = $enrolledClasses->pluck('id');
        $newMaterial = ClassMaterial::whereIn('class_id', $classIds)->latest()->first();
        if ($newMaterial) {
            $notifications->push(self::make(
                'Learning material available',
                $newMaterial->title . ' has been uploaded for your class.',
                'success',
                self::safeRoute('student.elearning'),
                $newMaterial->created_at
            ));
        }

        $newGrade = StudentGrade::where('student_id', $student->id)
            ->where('published', true)
            ->latest()
            ->first();

        if ($newGrade) {
            $notifications->push(self::make(
                'Grade update published',
                'Your latest average score is ' . number_format((float) $newGrade->average, 2) . '.',
                'success',
                self::safeRoute('student.progress'),
                $newGrade->updated_at ?? $newGrade->created_at
            ));
        }

        // Add user database notifications
        foreach ($student->unreadNotifications as $notification) {
            $notifications->push(self::make(
                $notification->data['title'] ?? 'Notification',
                $notification->data['message'] ?? '',
                $notification->data['type'] ?? 'info',
                $notification->data['action_url'] ?? '#',
                $notification->created_at
            ));
        }

        return self::sortAndLimit($notifications, $limit);
    }

    private static function make(string $title, string $message, string $type, string $url, $date): array
    {
        return [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'url' => $url,
            'date' => $date instanceof Carbon ? $date : Carbon::parse($date ?? now()),
        ];
    }

    private static function sortAndLimit(Collection $notifications, int $limit): Collection
    {
        return $notifications
            ->sortByDesc('date')
            ->take($limit)
            ->values();
    }

    private static function safeRoute(string $name): string
    {
        return Route::has($name) ? route($name) : '#';
    }
}
