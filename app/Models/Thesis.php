<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;
    protected $table = 'thesis';

    protected $fillable = [
        'id_category',
        'id_user',
        'title',
        'file_name',
        'abstract',
    ];

    public function category(){
        return $this->belongsTo(ThesisCategory::class, 'id_category', 'id');
    }

    public function user(){
        return $this->belongsTo(user::class, 'id_user', 'id');
    }
}
