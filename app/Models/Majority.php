<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majority extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'majority';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];
}
