<?php

namespace App\Repositories;

use App\Http\Controllers\Token\Uuid;
use Exception;
use App\Models\Movie;
use App\Models\MovieAndTag;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class MovieRepository
{
    protected $entity;

    public function __construct(Movie $model)
    {
        $this->entity = $model;
    }

    public function store(
        string $name,
        $movie,
        int $size_file,
        string $date_create
    ) {
        try {
            DB::beginTransaction();
            $file_name = $movie->hashName();
            $storeMovie = $movie->store('movies');
            if ($storeMovie) {
                $this->entity->create([
                    'name' => $name,
                    'file_name' => $file_name,
                    'size_file' => $size_file,
                    'date_create' => $date_create
                ]);
                DB::commit();
                return response()->json([
                    'message' => 'Movie created with success!',
                    'status' => 200
                ]);
            }else{
                DB::rollBack();
                return response()->json([
                    'message' => 'Failed in create movie!',
                    'status' => 401
                ]);
            }

            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 401
            ]);
        }
    }

    public function listMovies(
        string $name = null,
        string $orderByField = null,
        string $ascOrDesc = null,
    ) {
        $orderBy = $orderByField ? $orderByField : 'id';

        $response = $this->entity->with('tag')->orderBy($orderBy)->get();

        if($ascOrDesc!=null){
            $response = $this->entity->with('tag')->orderBy('id',$ascOrDesc)->get();
        }
        if($ascOrDesc!=null && $orderBy != 'id'){
            $response = $this->entity->with('tag')->orderBy($orderByField,$ascOrDesc)->get();
        }

        if($name!=null){
            $response = $this->entity->where('name', 'LIKE', "%{$name}%")->with('tag')->orderBy($orderBy)->get();
        }

        $uuid = new Uuid();
        $options = ['id'];
        return $uuid->transformer($response, $options);
    }

    public function updateMovies(
        int $movie_id,
        string $name = null,
        array $tags = null
    ){
        $uuid = new Uuid();
        $movie = $this->entity->find($uuid->id_decode($movie_id));
        $tags = MovieAndTag::where('id_movie',$uuid->id_decode($movie_id))->get();
        if($name != null){
            $movie->update([
                'name'=>$name
            ]);
        }
        return [$movie_id, $name,$tags ,$movie];
    }
}
