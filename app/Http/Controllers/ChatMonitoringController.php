<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMonitoringController extends Controller
{
    /**
     * Display chat monitoring page for admin.
     */
    public function index(Request $request)
    {
        $pairs = Message::selectRaw('LEAST(sender_id, receiver_id) as user1, GREATEST(sender_id, receiver_id) as user2')
            ->distinct()
            ->get();
            
        $conversations = [];
        foreach ($pairs as $pair) {
            $lastMessage = Message::where(function($q) use ($pair) {
                $q->where('sender_id', $pair->user1)->where('receiver_id', $pair->user2);
            })->orWhere(function($q) use ($pair) {
                $q->where('sender_id', $pair->user2)->where('receiver_id', $pair->user1);
            })->latest()->first();

            $user1 = User::find($pair->user1);
            $user2 = User::find($pair->user2);

            if (!$user1 || !$user2) {
                continue;
            }

            $conversations[] = (object)[
                'id' => $pair->user1 . '-' . $pair->user2,
                'user1' => $user1,
                'user2' => $user2,
                'student' => $user1->role === 'student' ? $user1 : $user2,
                'teacher' => $user1->role === 'teacher' ? $user1 : $user2,
                'messages' => collect([$lastMessage]),
                'last_message' => $lastMessage,
                'last_message_at' => $lastMessage->created_at,
            ];
        }

        usort($conversations, function($a, $b) {
            return $b->last_message_at <=> $a->last_message_at;
        });

        // Simple manual pagination wrapper for array
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = array_slice($conversations, ($currentPage - 1) * $perPage, $perPage);
        $conversations = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, count($conversations), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()
        ]);

        return view('admin.chat-monitoring', compact('conversations'));
    }

    /**
     * Get conversation messages.
     */
    public function getMessages($id)
    {
        // Check if user is admin or owner
        if (!in_array(Auth::user()->role, ['admin', 'owner'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        [$user1, $user2] = explode('-', $id);

        $u1 = User::find($user1);
        $u2 = User::find($user2);

        if (!$u1 || !$u2) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $messages = Message::where(function($q) use ($user1, $user2) {
                $q->where('sender_id', $user1)->where('receiver_id', $user2);
            })->orWhere(function($q) use ($user1, $user2) {
                $q->where('sender_id', $user2)->where('receiver_id', $user1);
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'student' => $u1->role === 'student' ? $u1 : $u2,
            'teacher' => $u1->role === 'teacher' ? $u1 : $u2,
        ]);
    }

    /**
     * Get conversation details with pagination.
     */
    public function getConversationDetails($id, Request $request)
    {
        // Check if user is admin or owner
        if (!in_array(Auth::user()->role, ['admin', 'owner'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        [$user1, $user2] = explode('-', $id);

        $u1 = User::find($user1);
        $u2 = User::find($user2);

        if (!$u1 || !$u2) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $messages = Message::where(function($q) use ($user1, $user2) {
                $q->where('sender_id', $user1)->where('receiver_id', $user2);
            })->orWhere(function($q) use ($user1, $user2) {
                $q->where('sender_id', $user2)->where('receiver_id', $user1);
            })
            ->with('sender')
            ->latest()
            ->paginate(30);

        return response()->json([
            'success' => true,
            'messages' => $messages->reverse(),
            'student' => $u1->role === 'student' ? $u1 : $u2,
            'teacher' => $u1->role === 'teacher' ? $u1 : $u2,
            'total_messages' => Message::where(function($q) use ($user1, $user2) {
                $q->where('sender_id', $user1)->where('receiver_id', $user2);
            })->orWhere(function($q) use ($user1, $user2) {
                $q->where('sender_id', $user2)->where('receiver_id', $user1);
            })->count(),
        ]);
    }
}
