<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikes extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getUserLike()
    {
        return $this->hasMany(User::class, 'id', 'like_id');
    }
}
