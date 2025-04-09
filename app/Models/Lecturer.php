<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Lecturer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    public $timestamps = true;
    protected $guard = 'lecturer';

    protected $fillable = [
        "topic_id",
        "name",
        "username",
        "email",
        "password",
        "profile_picture",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $hidden = [
        "password"
    ];

    public function thesis(): HasMany
    {
        return $this->hasMany(Thesis::class, "lecturer_id", "id");
    }

    /**
     * Get the topic that owns the lecturer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(ThesisTopic::class, 'topic_id', 'id');
    }
}
