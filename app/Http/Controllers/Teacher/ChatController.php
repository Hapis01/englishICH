<?php

namespace App\Http\Controllers\Teacher;

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
        $teacher = Auth::user();
        $chatStudents = $this->buildChatStudents($teacher);

        return view('teacher.chat', [
            'chatStudents' => $chatStudents,
            'selectedConversation' => null,
            'selectedStudentId' => null,
            'messages' => [],
        ]);
    }

    public function getAvailableStudents()
    {
        $students = User::where('role', 'student')
            ->where('status', 'active')
            ->select('id', 'name', 'email', 'profile_photo')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $students,
        ]);
    }

    public function getMessages($studentId)
    {
        $teacher = Auth::user();
        
        $student = User::where('id', $studentId)->where('role', 'student')->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        Message::where('sender_id', $studentId)
            ->where('receiver_id', $teacher->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where(function($q) use ($teacher, $studentId) {
                $q->where('sender_id', $teacher->id)->where('receiver_id', $studentId);
            })
            ->orWhere(function($q) use ($teacher, $studentId) {
                $q->where('sender_id', $studentId)->where('receiver_id', $teacher->id);
            })
            ->with('sender:id,name,profile_photo')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'student' => $student,
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $studentId)
    {
        $teacher = Auth::user();
        
        $student = User::where('id', $studentId)->where('role', 'student')->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
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
                'sender_id' => $teacher->id,
                'receiver_id' => $student->id,
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
        $teacher = Auth::user();
        
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::findOrFail($validated['student_id']);
        
        if ($student->role !== 'student') {
            return response()->json(['error' => 'Invalid student'], 400);
        }

        return response()->json([
            'success' => true,
            'conversation_id' => $student->id,
            'redirect' => route('teacher.chat.view', $student->id),
        ]);
    }

    public function view($studentId)
    {
        $teacher = Auth::user();
        
        $student = User::where('id', $studentId)->where('role', 'student')->first();

        if (!$student) {
            return redirect()->route('teacher.chat')->with('error', 'Student not found');
        }

        $messages = Message::where(function($q) use ($teacher, $studentId) {
                $q->where('sender_id', $teacher->id)->where('receiver_id', $studentId);
            })
            ->orWhere(function($q) use ($teacher, $studentId) {
                $q->where('sender_id', $studentId)->where('receiver_id', $teacher->id);
            })
            ->with('sender:id,name,profile_photo')
            ->orderBy('created_at', 'asc')
            ->get();

        Message::where('sender_id', $studentId)
            ->where('receiver_id', $teacher->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $chatStudents = $this->buildChatStudents($teacher);
        
        $conversation = (object)[
            'id' => $student->id,
            'teacher' => $teacher,
            'student' => $student,
        ];

        return view('teacher.chat', [
            'chatStudents' => $chatStudents,
            'selectedConversation' => $conversation,
            'selectedStudentId' => $studentId,
            'selectedStudent' => $student,
            'messages' => $messages,
        ]);
    }

    private function buildChatStudents(User $teacher)
    {
        $students = User::where('role', 'student')
            ->where('status', 'active')
            ->select('id', 'name', 'email', 'profile_photo')
            ->orderBy('name')
            ->get();

        $sorted = $students->map(function ($student) use ($teacher) {
            $lastMessage = Message::where(function($q) use ($teacher, $student) {
                    $q->where('sender_id', $teacher->id)->where('receiver_id', $student->id);
                })
                ->orWhere(function($q) use ($teacher, $student) {
                    $q->where('sender_id', $student->id)->where('receiver_id', $teacher->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            $unreadCount = Message::where('sender_id', $student->id)
                ->where('receiver_id', $teacher->id)
                ->where('is_read', false)
                ->count();

            $conversation = $lastMessage ? (object)[
                'id' => $student->id,
                'last_message_at' => $lastMessage->created_at,
                'teacher' => $teacher,
                'student' => $student,
            ] : null;

            return [
                'student' => $student,
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
                return strcmp($a['student']->name, $b['student']->name);
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
