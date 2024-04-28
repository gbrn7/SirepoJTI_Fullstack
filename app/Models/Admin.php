<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    public $timestamps = true;
    protected $table = 'admin';
    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_picture',
        'created_at',
        'updated_at'
    ];


    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];
}
