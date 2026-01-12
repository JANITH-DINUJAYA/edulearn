<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Show the main chat interface
     */
    public function index()
    {
        $authId = Auth::id();

        // Get only users (teachers) this student has actually chatted with
        $users = User::whereHas('messagesSent', function ($query) use ($authId) {
                $query->where('recipient_id', $authId);
            })
            ->orWhereHas('messagesReceived', function ($query) use ($authId) {
                $query->where('sender_id', $authId);
            })
            ->get();

        return view('student.messages.index', compact('users'));
    }

    /**
     * Fetch conversation history for Alpine.js
     */
    public function fetch($userId) {
        return Message::where(function($q) use ($userId) {
            $q->where('sender_id', Auth::id())->where('recipient_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)->where('recipient_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();
    }

    /**
     * Show initial form to contact a teacher from course page
     */
    public function create(Request $request)
    {
        $recipientId = $request->query('recipient_id');
        $teacher = User::findOrFail($recipientId);

        return view('student.messages.create', compact('teacher'));
    }

    /**
     * Handle sending a message (Supports both Form redirect and AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'body' => 'required|string|min:1',
        ]);

        try {
            $message = Message::create([
                'sender_id'    => Auth::id(),
                'recipient_id' => $request->recipient_id,
                'subject'      => 'Course Inquiry',
                'body'         => $request->body,
            ]);

            // If the request comes from the Chat UI (AJAX), return JSON
            if ($request->wantsJson()) {
                return response()->json($message);
            }

            // If the request comes from the 'Create' form, redirect
            return redirect()->route('student.messages.index')
                             ->with('success', 'Your message has been sent!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Database Error: ' . $e->getMessage()]);
        }
    }
}
