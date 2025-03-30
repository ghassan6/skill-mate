<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = ['receiver_id', 'sender_id', 'service_id', 'amount', 'method'];

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    protected $dates = ['deleted_at'];
}
