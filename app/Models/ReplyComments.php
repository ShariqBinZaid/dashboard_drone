<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyComments extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getReplyCommnet()
    {
        return $this->belongsTo(UserComments::class, 'commnet_id', 'id');
    }
}
