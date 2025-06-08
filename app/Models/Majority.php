<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Majority extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = true;
    protected $table = 'majority';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
