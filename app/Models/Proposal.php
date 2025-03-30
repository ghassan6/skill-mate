<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Proposal extends Model
{   
    use SoftDeletes;
    protected $fillable = ['user_id', 'service_id', 'content', 'price', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    protected $dates = ['deleted_at'];
    
}
