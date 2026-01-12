<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
public function index()
{
    $authId = Auth::id();

    // Get IDs of users who have chatted with the current instructor
    $users = User::whereHas('messagesSent', function ($query) use ($authId) {
            $query->where('recipient_id', $authId);
        })
        ->orWhereHas('messagesReceived', function ($query) use ($authId) {
            $query->where('sender_id', $authId);
        })
        ->get();

    return view('teacher.messages.index', compact('users'));
}
    public function fetch($userId) {
        // Querying based on your model's sender_id and recipient_id
        return Message::where(function($q) use ($userId) {
            $q->where('sender_id', Auth::id())->where('recipient_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)->where('recipient_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();
    }

    // App\Http\Controllers\Teacher\MessageController.php

public function store(Request $request) {
    $request->validate([
        'recipient_id' => 'required|exists:users,id',
        'body' => 'required|string'
    ]);

    $message = Message::create([
        'sender_id' => Auth::id(),
        'recipient_id' => $request->recipient_id,
        'body' => $request->body,
        'subject' => 'Direct Message',
    ]);

    // Return JSON so Alpine.js can push it into the 'messages' array
    return response()->json($message);
}
}
