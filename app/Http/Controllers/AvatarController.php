<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\AvatarCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $avatars = Avatar::all();
        $user = Auth::user(); // Get the authenticated user
    
        return view('avatars.index', compact('avatars', 'user'));
    }
    

    public function buy(Request $request, $avatarId)
    {
        return DB::transaction(function () use ($request, $avatarId) {
            $avatar = Avatar::findOrFail($avatarId);
            $user = Auth::user();
    
            // Check if the user has already purchased the avatar
            $existingCollection = AvatarCollection::where('sender_id', $user->id)
                                                  ->where('avatar_id', $avatarId)
                                                  ->first();
    
            if ($existingCollection) {
                return back()->with('error', 'You have already purchased this avatar.');
            }
    
            if ($user->coins >= $avatar->avatar_price) {
                $user->coins -= $avatar->avatar_price;
                $user->save();  // Save the updated user data
    
                // Create a new record in AvatarCollection
                AvatarCollection::create([
                    'sender_id' => $user->id,
                    'receiver_id' => $user->id, // Assuming receiver_id is the buyer
                    'avatar_id' => $avatar->id
                ]);
    
                return back()->with('success', 'Avatar purchased successfully!');
            } else {
                return back()->with('error', 'Not enough coins.');
            }
        });
    }
    
    public function showCollection()
    {
        // Get the current user
        $user = Auth::user();

        // Get the user's avatar collection
        $avatars = AvatarCollection::where('sender_id', $user->id)->get();

        return view('avatars.collection', compact('avatars'));
    }

    // Set the main avatar
    public function setMainAvatar($avatarId)
    {
        $user = Auth::user();

        // Check if the user owns the avatar
        $avatarCollection = AvatarCollection::where('sender_id', $user->id)
                                            ->where('avatar_id', $avatarId)
                                            ->first();

        if ($avatarCollection) {
            // Update the user's avatar_id to the selected main avatar
            $user->update([
                'avatar_id' => $avatarId
            ]);

            return back()->with('success', 'Main avatar updated successfully!');
        }

        return back()->with('error', 'Avatar not found in your collection.');
    }
    
    public function topUp(Request $request)
{
    $user = Auth::user(); // Get the authenticated user

    // Add 100 coins to the user's balance
    $user->coins += 100;
    $user->save();  // Save the updated user data

    return back()->with('success', '100 Coins added to your account!');
}

    
    
}
