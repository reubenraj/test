<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrayerRequestReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'prayer_request_id',
        'user_id',
        'reply',
    ];

    public function prayerRequest()
    {
        return $this->belongsTo(PrayerRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
