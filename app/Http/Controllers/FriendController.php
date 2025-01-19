<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function __construct()
    {
        // Ensure only unauthenticated users can access these methods
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Search and filter logic
        $query = User::query();
    
        // Exclude the currently authenticated user from the query
        $query->where('id', '!=', Auth::id()); // Exclude self
    
        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // Filter by field of work
        if ($request->has('field_of_work') && $request->field_of_work) {
            $query->where('field_of_work', $request->field_of_work);
        }
    
        // Get distinct field of work options
        $fields = User::select('field_of_work')->distinct()->pluck('field_of_work');
    
        // Paginate the users (ensure pagination is used here)
        $users = $query->paginate(3);
    
        // Get the IDs of users who have already received a thumb from the authenticated user
        $thumbedUsers = Friend::where('sender_id', Auth::id())->pluck('receiver_id')->toArray();
    
        // Pass data to the view
        return view('friends', compact('users', 'fields', 'thumbedUsers'));
    }
    
    

    public function giveThumb($id)
    {
        // Logic for sending a friend request
        $exists = Friend::where('sender_id', Auth::id())
            ->where('receiver_id', $id)
            ->exists();

        if (!$exists) {
            Friend::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $id,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('friends')->with('success', 'Thumb sent successfully!');
    }
}
