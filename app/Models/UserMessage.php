<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use HasFactory;

    protected $table = 'user_messages';

    protected $fillable = [
        'user_id',
        'chat_id',
        'message_id',
        'message',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * User bilan bog‘lanish
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
