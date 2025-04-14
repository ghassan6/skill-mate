<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'rating',
        'city_id',
        'phone_number',
        'bio',
        'listing_limit',
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

    // methos realeated to saved services


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


}
