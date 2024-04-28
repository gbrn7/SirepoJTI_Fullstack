<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'thesis';

    protected $fillable = [
        'id_category',
        'id_user',
        'title',
        'file_name',
        'abstract',
        'created_at',
        'updated_at'
    ];

    public function category(){
        return $this->belongsTo(ThesisCategory::class, 'id_category', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
