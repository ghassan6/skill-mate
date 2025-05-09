<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ServiceImage extends Model
{
    use SoftDeletes;
    protected $fillable = ['service_id', 'image'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    protected $dates = ['deleted_at'];
}
