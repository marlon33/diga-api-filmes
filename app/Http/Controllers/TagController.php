<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    protected $repository;

    public function __construct(TagRepository $authRepository)
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }

        $response = $this->repository->store(
            $request->name
        );
        return response()->json($response);
    }
}
