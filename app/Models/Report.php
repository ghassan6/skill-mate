<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['reporter_id', 'reported_user_id', 'service_id',  'reason', 'details', 'status']; /* 'review_id' to be added */

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // TODO
    // public function review()
    // {
    //     return $this->belongsTo(Review::class);
    // }

}
