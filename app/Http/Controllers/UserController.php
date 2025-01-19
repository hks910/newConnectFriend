<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        // Ensure only unauthenticated users can access these methods
        $this->middleware('auth');
    }

    public function friendRequests(Request $request)
        {
            $userId = Auth::id();
            $query = Friend::with('sender')
                        ->where('receiver_id', $userId)
                        ->where('status', 'Pending'); // Adjust based on your database schema

            $friends = $query->paginate(10);

            return view('friend_requests', compact('friends'));
        }

        public function acceptFriendRequest($friendId)
        {
            $friend = Friend::find($friendId);
            if ($friend && $friend->receiver_id === Auth::id()) {
                $friend->update(['status' => 'Accepted']);
                return back()->with('success', 'Friend request accepted.');
            }
            return back()->with('error', 'Invalid operation.');
        }

        public function declineFriendRequest($friendId)
        {
            $friend = Friend::find($friendId);
            if ($friend && $friend->receiver_id === Auth::id()) {
                $friend->update(['status' => 'Declined']);
                return back()->with('success', 'Friend request declined.');
            }
            return back()->with('error', 'Invalid operation.');
        }


}
