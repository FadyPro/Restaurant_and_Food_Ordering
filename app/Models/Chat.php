<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];


    function sender() {
        return $this->belongsTo(User::class, 'sender_id')->select('id', 'avatar','name');
    }

    function receiver() {
        return $this->belongsTo(User::class, 'receiver_id')->select('id', 'avatar');
    }
}
