<?php

namespace App\Services;

use App\Http\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @return Application|Factory|View|RedirectResponse
     */
    public function loginWeb($login)
    {
        if (Auth::attempt($login)) {
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    public function registerWeb($register)
    {
        $register['referred_by'] = $this->getSessionReferrer();
        $register['affiliate_id'] = $this->createAffiliateId();
        $register['password'] = $this->makeHashPassord($register['password']);

        $user = $this->userRepository->createAccount($register);
        if (!$user) {
            return view('public/home');
        }

        Auth::loginUsingId($user->id);
        if ($user->type_user !== 'empresa') {
            return redirect()->intended('dashboard');
        }

        return view('public/home');
    }

    public function login($user): JsonResponse
    {
        $data = $this->userRepository->getUserEmail($user['email']);

        if ($this->checkPasswordLogin($data, $user['password'])) {
            return response()->json([
                'data' => ['token' => $this->createToken($data)]]);
        }

        return response()->json([
            'message' => 'As credenciais fornecidas não correspondem aos nossos registros.',
            "errors" => [
                "email" => [
                    "Email is invalid."
                ],
                "password" => [
                    "Password is invalid."
                ]
            ]],
            403);
    }


    private function getSessionReferrer()
    {
        if (session()->get('referrer_id')) {
            return session()->get('referrer_id');
        }
        return null;
    }

    private function createAffiliateId()
    {
        return mb_strtoupper(uniqid("AI"));
    }

    private function makeHashPassord($password): string
    {
        return Hash::make($password);
    }

    public function setSessionReferrer($referrer_id)
    {
        session(['referrer_id' => $referrer_id]);
    }


    /**
     * @param $user
     * @param $password
     * @return bool
     */
    private function checkPasswordLogin($user, $password): bool
    {
        return Hash::check($password, $user->password);
    }

    /**
     * Convert data in JWT
     * @param $user
     * @return string
     */
    private function createToken($user): string
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
