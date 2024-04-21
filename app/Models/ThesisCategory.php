<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThesisCategory extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'thesis_category';

    protected $fillable = [
        'category',
        'created_at',
        'updated_at'
    ];
}
