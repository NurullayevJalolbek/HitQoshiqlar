<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model
{
    protected $table = 'youtube_videos';

    protected $fillable = [
        'video_id',
        'url',
        'title',
        'formats',
        'fetched_at',
    ];

    protected $casts = [
        'formats' => 'array',
    ];
}
