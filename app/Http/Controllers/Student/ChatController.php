<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $chatTeachers = $this->buildChatTeachers($student);

        return view('student.chat', [
            'chatTeachers' => $chatTeachers,
            'selectedConversation' => null,
            'selectedTeacherId' => null,
            'messages' => [],
        ]);
    }

    public function getAvailableTeachers()
    {
        $teachers = User::where('role', 'teacher')
            ->where('status', 'active')
            ->select('id', 'name', 'email', 'profile_photo')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $teachers,
        ]);
    }

    public function getMessages($teacherId)
    {
        $student = Auth::user();
        
        $teacher = User::where('id', $teacherId)->where('role', 'teacher')->first();

        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        Message::where('sender_id', $teacherId)
            ->where('receiver_id', $student->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where(function($q) use ($student, $teacherId) {
                $q->where('sender_id', $student->id)->where('receiver_id', $teacherId);
            })
            ->orWhere(function($q) use ($student, $teacherId) {
                $q->where('sender_id', $teacherId)->where('receiver_id', $student->id);
            })
            ->with('sender:id,name,profile_photo')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'teacher' => $teacher,
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $teacherId)
    {
        $student = Auth::user();
        
        $teacher = User::where('id', $teacherId)->where('role', 'teacher')->first();

        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        $validated = $request->validate([
            'message' => 'nullable|string|max:5000|required_without:attachment',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        try {
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $directory = public_path('images/chat');
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
                $fileName = 'chat_' . time() . '_' . Str::random(6) . '_' . $safeName;
                $file->move($directory, $fileName);
                $attachmentPath = 'images/chat/' . $fileName;
            }

            $message = Message::create([
                'sender_id' => $student->id,
                'receiver_id' => $teacher->id,
                'message' => $validated['message'] ?? '',
                'attachment' => $attachmentPath,
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => $message->load('sender:id,name,profile_photo'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function startConversation(Request $request)
    {
        $student = Auth::user();
        
        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
        ]);

        $teacher = User::findOrFail($validated['teacher_id']);
        
        if ($teacher->role !== 'teacher') {
            return response()->json(['error' => 'Invalid teacher'], 400);
        }

        return response()->json([
            'success' => true,
            'conversation_id' => $teacher->id,
            'redirect' => route('student.chat.view', $teacher->id),
        ]);
    }

    public function view($teacherId)
    {
        $student = Auth::user();
        
        $teacher = User::where('id', $teacherId)->where('role', 'teacher')->first();

        if (!$teacher) {
            return redirect()->route('student.chat')->with('error', 'Teacher not found');
        }

        $messages = Message::where(function($q) use ($student, $teacherId) {
                $q->where('sender_id', $student->id)->where('receiver_id', $teacherId);
            })
            ->orWhere(function($q) use ($student, $teacherId) {
                $q->where('sender_id', $teacherId)->where('receiver_id', $student->id);
            })
            ->with('sender:id,name,profile_photo')
            ->orderBy('created_at', 'asc')
            ->get();

        Message::where('sender_id', $teacherId)
            ->where('receiver_id', $student->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $chatTeachers = $this->buildChatTeachers($student);
        
        $conversation = (object)[
            'id' => $teacher->id,
            'teacher' => $teacher,
            'student' => $student,
        ];

        return view('student.chat', [
            'chatTeachers' => $chatTeachers,
            'selectedConversation' => $conversation,
            'selectedTeacherId' => $teacherId,
            'selectedTeacher' => $teacher,
            'messages' => $messages,
        ]);
    }

    private function buildChatTeachers(User $student)
    {
        $teachers = User::where('role', 'teacher')
            ->where('status', 'active')
            ->select('id', 'name', 'email', 'profile_photo')
            ->orderBy('name')
            ->get();

        $sorted = $teachers->map(function ($teacher) use ($student) {
            $lastMessage = Message::where(function($q) use ($student, $teacher) {
                    $q->where('sender_id', $student->id)->where('receiver_id', $teacher->id);
                })
                ->orWhere(function($q) use ($student, $teacher) {
                    $q->where('sender_id', $teacher->id)->where('receiver_id', $student->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            $unreadCount = Message::where('sender_id', $teacher->id)
                ->where('receiver_id', $student->id)
                ->where('is_read', false)
                ->count();

            $conversation = $lastMessage ? (object)[
                'id' => $teacher->id,
                'last_message_at' => $lastMessage->created_at,
                'teacher' => $teacher,
                'student' => $student,
            ] : null;

            return [
                'teacher' => $teacher,
                'conversation' => $conversation,
                'lastMessage' => $lastMessage,
                'unreadCount' => $unreadCount,
            ];
        })->sort(function ($a, $b) {
            if ($a['lastMessage'] && $b['lastMessage']) {
                return $b['lastMessage']->created_at <=> $a['lastMessage']->created_at;
            } elseif ($a['lastMessage']) {
                return -1;
            } elseif ($b['lastMessage']) {
                return 1;
            } else {
                return strcmp($a['teacher']->name, $b['teacher']->name);
            }
        })->values();

        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $sorted->forPage($page, $perPage),
            $sorted->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }
}
