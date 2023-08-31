<?php

namespace App\Models;

use App\Models\Subscriptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSubscriptions extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function userSubscriptions()
    {
        return $this->belongsTo(Subscriptions::class, 'subscriptions_id', 'id');
    }
}
