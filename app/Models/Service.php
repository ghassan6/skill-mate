<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'type',
        'status',
        'min_price',
        'max_price',
        'hourly_rate',
        'city_id',
        'address',
        'views',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->hasMany(ServiceImage::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function proposals() {
        return $this->hasMany(Proposal::class);
    }

    public function savedBy() {
        return $this->belongsToMany(User::class, 'saved_services');
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function inquiries() {
        return $this->hasMany(Inquiry::class);
    }


    protected $dates = ['deleted_at'];
}
