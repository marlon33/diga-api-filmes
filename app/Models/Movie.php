<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'file_name',
        'size_file',
        'date_create',
    ];

    public function tag(){
        // return $this->belongsToMany(Tag::class);
        
        return $this->belongsToMany('App\Models\Tag','movie_and_tag', 'id_movie', 'id_tag');
    }
}
