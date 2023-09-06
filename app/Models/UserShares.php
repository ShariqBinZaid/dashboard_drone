<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShares extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getUserShare()
    {
        return $this->hasMany(User::class, 'id', 'share_id');
    }
}
