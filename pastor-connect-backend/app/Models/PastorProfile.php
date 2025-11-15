<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PastorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_church_name',
        'current_church_address',
        'denomination',
        'ordination_status',
        'ordination_date',
        'bio',
        'profile_image',
    ];

    protected $casts = [
        'ordination_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
