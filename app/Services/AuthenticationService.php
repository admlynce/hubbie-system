<?php

namespace App\Services;

use App\Http\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @param $login
     * @return RedirectResponse
     */
    public function loginWeb($login): RedirectResponse
    {
        dd($login);
        if (Auth::attempt($login)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function login($user): JsonResponse
    {
        $data = $this->userRepository->getUserEmail($user['email']);

        if ($this->checkPasswordLogin($data, $user['password'])) {
            return response()->json([
                'data' => ['token' => $this->createToken($data)]]);
        }

        return response()->json([
            'message' => 'Senha incorreta',
            "errors" => [
                "password" => [
                    "Password is invalid."
                ]
            ]],
            403);
    }

    /**
     * @param $user
     * @param $password
     * @return bool
     */
    protected function checkPasswordLogin($user, $password): bool
    {
        return Hash::check($password, $user->password);
    }

    /**
     * Convert data in JWT
     * @param $user
     * @return string
     */
    protected function createToken($user): string
    {
        $payload = [
            'iss' => "hubbie-jwt", // Issuer of the token
            'data' => $user, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + (200 * 24 * 60 * 60)// Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
