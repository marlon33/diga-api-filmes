<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Token\Token;

class UserRepository
{
    protected $entity;

    public function __construct(User $model)
    {
        $this->entity = $model;
    }

    public function login(
        string $email,
        string $password
    ) {
        try {
            $user = $this->entity
                ->where('email', $email)
                ->first();
            if (!Hash::check($password, $user->password)) {
                return response()->json([
                        'message' => 'E-mail or password was wrong',
                        'status' => 401
                    ]);
            }

            $token = new Token();
            $tokenResult = $token->encode($user->id, $user->name, $user->email);
            return response()->json([
                    'message' => $tokenResult->original,
                    'status' => 200
                ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 401
            ]);
        }
    }

    public function register(
        string $name,
        string $email,
        string $password
    ) {
        try {
            $this->entity->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password)
            ]);

            return response()->json([
                'message' => 'User has been registered',
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 401
            ]);
        }
    }
}
