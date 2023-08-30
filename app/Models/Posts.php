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
        return $this->belongsTo(Categories::class, 'categorys_id', 'id');
    }
}
