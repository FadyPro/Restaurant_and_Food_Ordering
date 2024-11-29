<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    function blog() {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
