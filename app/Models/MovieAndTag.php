<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieAndTag extends Model
{
    use HasFactory;  

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'id_movie',
        'id_tag',
    ];
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];
}
