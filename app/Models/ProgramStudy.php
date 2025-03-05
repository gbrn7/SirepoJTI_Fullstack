<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudy extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = true;
    protected $table = 'program_study';

    protected $fillable = [
        'id_majority',
        'name',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function majority(): BelongsTo
    {
        return $this->belongsTo(Majority::class, 'id_majority', 'id');
    }
}
