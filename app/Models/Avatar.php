<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatars';

    protected $fillable = [
        'avatar_name',
        'avatar_price',
        'avatar_image'
    ];

    public function avatarCollection(){
        return $this->hasMany(AvatarCollection::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }


    use HasFactory;
}
