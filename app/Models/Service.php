<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Reverb\Protocols\Pusher\Server;

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
        return !$this->reviews()
        ->where('user_id', $user->id)->exists()
        && $this->inquiries()->where('user_id', $user->id)
        ->where('status', 'completed')->exists();


    }

    public function hasReviewed(User $user) {
        return $this->reviews()
        ->where('user_id', $user->id)->exists();
    }

    public function createSlug($title) {

        $count = 1;
        $slug = Str::slug($title);
        if(!Service::where('slug', Str::slug($title))->exists()) {
            return $slug ;
        }

        while (Service::where('slug', $slug)->exists()) {
            $slug = Str::slug($title) . '-' . $count;
            $count++;
        }

        return $slug;
    }

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'featured_until' => 'datetime',
    ];
}
