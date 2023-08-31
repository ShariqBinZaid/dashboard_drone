<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscriptions extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getSubscriptions()
    {
        return $this->belongsTo(Subscriptions::class, 'id', 'subscriptions_id');
    }
}
