<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class YoutubeSearchResult extends Model
{
    protected $table = 'youtube_search_results';

    protected $fillable = [
        'query_id',
        'video_id',
        'title',
        'position',
        'source',
    ];

    // Har bir natija → bitta queryga tegishli
    public function getSearchQuery(): BelongsTo
    {
        return $this->belongsTo(YoutubeSearchCache::class, 'query_id');
    }
}
