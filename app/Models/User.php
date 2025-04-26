<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
        'role',
        'city_id',
        'phone_number',
        'bio',
        'listing_limit',
        'banned_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone_number' => 'string',
        ];
    }

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function proposals() {
        return $this->hasMany(Proposal::class);
    }


    public function city() {
        return $this->belongsTo(City::class);
    }

    public function sentPayments()
    {
        return $this->hasMany(Payment::class, 'sender_id');
    }

    public function receivedPayments()
    {
        return $this->hasMany(Payment::class, 'receiver_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    protected $dates = ['deleted_at'];

    // methos releated to saved services


    public function savedServices() {
        return $this->hasMany(SavedService::class, 'user_id')->whereNull('deleted_at');

    }

    public function isServiceSaved($serviceId)
    {
        return $this->savedServices()->withTrashed()->where('service_id', $serviceId)->exists();
    }

    public function savedServiceItems()
    {
        return $this->belongsToMany(Service::class, 'saved_services', 'user_id', 'service_id')
        ->whereNull('saved_services.deleted_at') // Only if you're using soft deletes
        ->withTimestamps();
    }

    public function inquiries() {
        return $this->hasMany(Inquiry::class);
    }

    public function averageRating()
    {
        $serviceIds = $this->services()->pluck('id');
        return Review::whereIn('service_id', $serviceIds)->avg('rating');
    }

    public function totalReviews() {
        $serviceIds = $this->services()->pluck('id');
        return Review::whereIn('service_id', $serviceIds)->count();
    }

    // for message (messageing system)
    public function conversations()
    {
        return Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
    }
    public function completedServices()
    {
        return $this->services()
            ->whereHas('inquiries', function ($query) {
                $query->where('status', 'completed');
            });
    }

    public function isBanned()
    {
        return !is_null($this->banned_at);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            // Delete all related services when a user is soft deleted
            $user->services()->delete();
        });
    }
}
