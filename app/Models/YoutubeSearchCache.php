<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YoutubeSearchCache extends Model
{
    protected $table = 'youtube_search_cache';

    protected $fillable = [
        'query_key',
        'query_text',
        'normalized_query',
        'clean_query',
        'hit_count',
        'last_hit_at',
        'fetched_at',
    ];

    protected $casts = [
        'hit_count'   => 'integer',
        'last_hit_at' => 'datetime',
        'fetched_at'  => 'datetime',
    ];

    public function results(): HasMany
    {
        return $this->hasMany(YoutubeSearchResult::class, 'query_id');
    }
}
