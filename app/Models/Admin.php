<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'admin';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'profile_picture',
        'created_at',
        'updated_at'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];
}
