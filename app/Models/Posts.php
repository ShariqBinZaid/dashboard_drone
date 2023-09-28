<?php

namespace App\Models;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCategorys()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(UserComments::class, 'user_id', 'user_id');
    }
    public function likes()
    {
        return $this->hasMany(UserLikes::class, 'user_id', 'user_id');
    }
}
