<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        // Ensure only unauthenticated users can access these methods
        $this->middleware('auth');
    }
    public function index()
    {
        $userId = Auth::id();
    
        // Fetch users with whom the current user has an accepted friendship
        $friends = User::whereHas('friends', function ($query) use ($userId) {
            $query->where('sender_id', $userId);  // Your user as the receiver in the friend table
        })->orWhereHas('friendedBy', function ($query) use ($userId) {
            $query->where('receiver_id', $userId);  // Your user as the sender in the friend table
        })->get();
    
        return view('messages.index', compact('friends'));
    }
    

    public function chat($friendId)
    {
        $friend = User::findOrFail($friendId);
        $messages = Message::where(function ($query) use ($friendId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('sender_id', $friendId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();
    
        return view('messages.chat', compact('messages', 'friend'));
    }
    

    public function sendMessage(Request $request, $receiverId)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->input('message'),
        ]);

        return back()->with('success', 'Message sent successfully!');
    }
}
