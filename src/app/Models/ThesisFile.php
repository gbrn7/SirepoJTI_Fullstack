<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThesisFile extends Model
{
    use HasFactory;
    public $timestamps = true;

    public $fillable = [
        "thesis_id",
        "label",
        "file_name",
        "sequence_num",
        "created_at",
        "updated_at",
    ];

    public function thesis(): BelongsTo
    {
        return $this->belongsTo(Thesis::class, 'thesis_id', 'id');
    }
}
