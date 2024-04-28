<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudy extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'program_study';

    protected $fillable = [
        'id_majority',
        'name',
        'created_at',
        'updated_at'
    ];

    public function majority(){
        return $this->belongsTo(Majority::class, 'id_majority', 'id');
    }
}
