<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Token\Token;
use Illuminate\Http\Request;
use App\Repositories\MovieRepository;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    protected $repository;

    public function __construct(MovieRepository $authRepository)
    {
        $this->repository = $authRepository;
    }


    /**
     * Create a new movie.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'movie'=>'required|file|mimes:mp4,mov,ogg,qt|max:5000',
            'size_file'=>'required|int',
            'date_create'=>'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }

        $token = new Token();
        $status = $token->authToken()->getData()->status;
        if($status == 'fail'){
            return $token->authToken();
        }

        $response = $this->repository->store(
            $request->name,
            $request->file('movie'),
            $request->size_file,
            $request->date_create
        );
        return response()->json($response);
    }

    public function listMovies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'nullable|string',
            'orderByField'=>'nullable|string',
            'ascOrDesc'=>'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }

        $token = new Token();
        $status = $token->authToken()->getData()->status;
        if($status == 'fail'){
            return $token->authToken();
        }

        $response = $this->repository->listMovies(
            $request->name,
            $request->orderByField,
            $request->ascOrDesc,
        );
        return response()->json($response);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'movie_id'=>'required|int',
            'name'=>'nullable|string',
            'tags'=>'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }
        
        // $token = new Token();
        // $status = $token->authToken()->getData()->status;
        // if($status == 'fail'){
        //     return $token->authToken();
        // }

        
        $response = $this->repository->updateMovies(
            $request->movie_id,
            $request->name,
            $request->tags
        );
        return response()->json($response);
    }
}
