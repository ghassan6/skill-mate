<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedService extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['user_id', 'service_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    protected $dates = ['deleted_at'];


}
