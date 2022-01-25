<?php

namespace App\Services;

use App\Http\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        public UserRepository $userRepository
    )
    {
    }

    public function login($user)
    {
        $data = $this->userRepository->getUserEmail($user['email']);
        if (!is_null($data)) {
            return $this->checkPasswordLogin($data, $user['password']);
        }
        return response()->json(['error' => 'Usuario não encontrado'], 401);
    }

    protected function checkPasswordLogin($user, $password)
    {
        if (Hash::check($password, $user->password)) {
            return response()->json([
                'token' => $this->createToken($user)
            ]);
        } else {
            return response()->json([
                'error' => 'Senha incorreta.'
            ], 401);
        }
    }

    /**
     * Convert data in JWT
     *
     * @return string
     */
    protected function createToken($data)
    {
        $payload = [
            'iss' => "hubbie-jwt", // Issuer of the token
            'data' => $data, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + (200 * 24 * 60 * 60)// Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function register($data)
    {
        $data['password'] = md5($data['password']);

        return response(['user' => $this->repository->store($data), 'message' => 'Usuário cadastrado com sucesso']);
    }

}
