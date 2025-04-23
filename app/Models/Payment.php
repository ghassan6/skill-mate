<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = ['sender_id', 'service_id', 'amount', 'method'];


    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    protected $dates = ['deleted_at'];
}
