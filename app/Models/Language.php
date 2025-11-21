<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',     // Til nomi, masalan: "O'zbek"
        'url',      // Til kodi, masalan: "uz", "en", "ar"
        'icon',     // Bayroq SVG URL
        'default',  // Default til yoki yo'qligi (boolean)
        'status',   // Tilning holati: active/inactive
    ];


}
