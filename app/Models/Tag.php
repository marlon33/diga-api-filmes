<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;  

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];
    public function movie(){
        // return $this->belongsToMany(Movie::class);
        return $this->belongsToMany('App\Models\Movie','movie_and_tag', 'id_movie', 'id_tag');
    }
}
