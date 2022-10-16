<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Token\Token;
use App\Http\Controllers\Token\Uuid;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserControler extends Controller
{

    protected $repository;

    public function __construct(UserRepository $authRepository)
    {
        $this->repository = $authRepository;
    }


    /**
     * Resgister a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }

        $response = $this->repository->register(
            $request->name,
            $request->email,
            $request->password
        );
        return response()->json($response);
    }

    /**
     * make login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }

        return $this->repository->login(
            $request->email,
            $request->password
        );
    }
}
