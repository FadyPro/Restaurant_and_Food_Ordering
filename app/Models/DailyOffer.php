<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    function product() {
        return $this->belongsTo(Product::class);
    }
}
