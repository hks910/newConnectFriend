<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvatarCollection extends Model
{
    protected $table = 'avatarCollections';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'avatar_id'
    ];

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }


    public function avatar(){
        return $this->belongsTo(Avatar::class, 'avatar_id');
    }


    

    use HasFactory;
}
