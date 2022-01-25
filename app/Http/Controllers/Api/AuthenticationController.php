<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

//    /**
//     * Login in api.
//     * @param LoginPostRequest $login
//     * @return JsonResponse
//     */
//    public function login(LoginPostRequest $login): JsonResponse
//    {
//        return $this->authenticationService->login($login);
//    }
}
