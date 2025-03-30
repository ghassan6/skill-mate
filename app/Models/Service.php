<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'status',
        'min_price',
        'max_price',
        'hourly_rate',
        'city',
        'address',
        'views',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->hasMany(ServiceImage::class);
    }
}
