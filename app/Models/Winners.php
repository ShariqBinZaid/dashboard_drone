<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winners extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getUser()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
