<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSubscriptions extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Subscriptions()
    {
        return $this->belongsTo(Subscriptions::class, 'subscriptions_id', 'id');
    }

    public function Posts()
    {
        return $this->belongsTo(Posts::class, 'post_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(UserLikes::class, 'post_id');
    }
}
