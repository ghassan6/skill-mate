<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'service_id', 'comment', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    protected $dates = ['deleted_at'];
}
