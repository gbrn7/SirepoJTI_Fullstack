<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudy extends Model
{
    use HasFactory;
    protected $table = 'program_study';

    protected $fillable = [
        'id_majority',
        'name',
    ];

    public function majority(){
        return $this->belongsTo(majority::class, 'id_majority', 'id');
    }
}
