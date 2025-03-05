<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThesisType extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = true;
    protected $table = 'thesis_types';

    protected $fillable = [
        'type',
        'created_at',
        'updated_at'
    ];

    public function thesistTypes(): HasMany
    {
        return $this->hasMany(Thesis::class, "type_id", "id");
    }
}
