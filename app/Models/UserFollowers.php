<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowers extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getUserFollower()
    {
        return $this->hasMany(User::class, 'id', 'follower_id');
    }

    public function getUser()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
