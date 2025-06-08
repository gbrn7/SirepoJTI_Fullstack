<?php

namespace App\Models;

use App\Support\model\GetThesisReqModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThesisTopic extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = true;

    protected $fillable = [
        "topic",
        "created_at",
        "updated_at",
        'deleted_at'
    ];


    public function thesis(): HasMany
    {
        return $this->hasMany(Thesis::class, "topic_id", "id");
    }
}
