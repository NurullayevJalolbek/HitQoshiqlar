<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Notifications\Notifiable;



use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = "musics";
    protected $fillable = [
        "yt_id",
        "field_id",
        "title",
        "artist"
    ];



    
}
