<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sermon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'scripture_reference',
        'content',
        'preached_date',
        'sermon_series',
        'tags',
        'is_published',
    ];

    protected $casts = [
        'preached_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
