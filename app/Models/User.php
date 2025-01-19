<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use HasFactory, Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'name',
            'email',
            'password',
            'gender',
            'field_of_work',
            'social_link',
            'phone_number',
            'coins',
            'isVisible',
            'avatar_id'
        ];

        public function senderMessage(){
            return $this->hasMany(Message::class, 'sender_id');
        }

        public function senderFriend(){
            return $this->hasMany(Friend::class);
        }
        public function senderAvatar(){
            return $this->hasMany(AvatarCollection::class);
        }

        public function receiverMessage(){
            return $this->hasMany(Message::class,'sender_id');
        }

        public function receiverFriend(){
            return $this->hasMany(Friend::class);
        }

        public function receiverAvatar(){
            return $this->hasMany(AvatarCollection::class);
        }

        public function mainAvatar(){
            return $this->belongsTo(Avatar::class, 'avatar_id');
        }

        public function sentMessages(){
            return $this->hasMany(Message::class, 'sender_id');
        }
    
        public function receivedMessages(){
            return $this->hasMany(Message::class, 'receiver_id');
        }
    
        public function friends(){
            return $this->hasMany(Friend::class, 'receiver_id')->where('status', 'Accepted');
        }
    
        public function friendedBy(){
            return $this->hasMany(Friend::class, 'sender_id')->where('status', 'Accepted');
        }


        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * Get the attributes that should be cast.
         *
         * @return array<string, string>
         */
        protected function casts(): array
        {
            return [
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
            ];
        }
    }
