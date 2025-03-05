<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thesis extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'thesis';

    protected $fillable = [
        'topic_id',
        'type_id',
        'lecturer_id',
        'student_id',
        'title',
        'abstract',
        'donwload_count',
        'note',
        'created_at',
        'updated_at'
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(ThesisTopic::class, 'topic_id', 'id');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(lecturer::class, 'lecturer_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ThesisType::class, 'type_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ThesisFile::class, "thesis_id", "id");
    }
}
