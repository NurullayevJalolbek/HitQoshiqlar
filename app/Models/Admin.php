<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'image',
        'fullname',
        'phone',
        'birthdate',
        'registered_by',
        'status',
    ];

    /**
     * Hidden fields (JSON / API chiqishda ko‘rinmaydi)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Type casting
     */
    protected $casts = [
        'birthdate' => 'date',
    ];
}
