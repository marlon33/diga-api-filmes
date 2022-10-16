<?php

namespace App\Http\Controllers\Token;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Http\Controllers\Token\Uuid;

class Token
{
    public function encode($userId, $name, $email)
    {
        try {
            $uuid = new Uuid();
            $expiration = time() + ($_ENV['JWT_EXPIRATION_TIME'] * 60);
            $token = array(
                "expiration" => $expiration,
                "user_id" => $uuid->id_encode($userId),
                // "name" => $name,
                // "email" => $email
            );

            $jwt = JWT::encode($token, $_ENV['JWT_SECRET_KEY'], 'HS256');
            return response()->json([
                // "name" => $name,
                // "email" => $email,
                'token' => $jwt,
                'expiration' => date('m/d/Y H:i:s', $expiration)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ]);
        }
    }


    public function authToken()
    {
        try {
            if (!array_key_exists("HTTP_AUTHORIZATION", $_SERVER)) {
                return response()->json(
                    [
                        'status' => 'fail',
                        'message' => 'Header Authorization do not found!'
                    ],
                    401
                );
            }
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            if (!str_contains($authHeader, 'Bearer')) {
                return response()->json(
                    [
                        'status' => 'fail',
                        'message' => 'Type Authorization Bearer not included!'
                    ],
                    401
                );
            }
            $getToken = explode(" ", $authHeader);
            $tokenJwt = $getToken[1];
            if ($tokenJwt) {
                $tokenDecode = JWT::decode($tokenJwt, new Key($_ENV['JWT_SECRET_KEY'], 'HS256'));
                if (!( $tokenDecode->expiration > time() )) {
                    return response()->json(
                        [
                            'status' => 'fail',
                            'message' => 'Access denied, the token already expirated, please renew the token'
                        ],
                        401
                    );
                }
                return response()->json($tokenDecode);
            }
        } catch (Exception $e) {
            return response()->json([
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ]);
        }
    }
}
