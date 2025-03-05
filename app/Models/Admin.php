<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    public $timestamps = true;
    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_picture',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];
}
