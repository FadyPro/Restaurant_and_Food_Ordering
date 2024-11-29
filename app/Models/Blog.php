<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];

    function category() {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    function user() {
        return $this->belongsTo(User::class);
    }

    function comments() {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id');
    }
}
