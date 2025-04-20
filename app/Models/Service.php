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
        'hourly_rate',
        'city_id',
        'address',
        'views',
        'slug',
        'status',
        'is_featured',
        'featured_until',
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

    // this for mark the service as completed
    // public function hasAcceptedInquiry($userId)
    // {
    //     return $this->inquiries()
    //         ->where('user_id', $userId)
    //         ->where('status', 'accepted')
    //         ->exists();
    // }

    // public function getAcceptedInquiryId($userId)
    // {
    //     return $this->inquiries()
    //         ->where('user_id', $userId)
    //         ->where('status', 'accepted')
    //         ->value('id');
    // }

    // for review related
    public function canReview(User $user)
    {
        // dd($user->id);
        // dd($this->reviews);
        return !$this->reviews()
        ->where('user_id', $user->id)->exists()
        && $this->inquiries()->where('user_id', $user->id)
        ->where('status', 'completed')->exists();


    }

    public function hasReviewed(User $user) {
        return $this->reviews()
        ->where('user_id', $user->id)->exists();
    }

    protected $dates = ['deleted_at'];
}
