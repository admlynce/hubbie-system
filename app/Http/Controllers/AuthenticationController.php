<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;

class AuthenticationController extends Controller
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function login(AuthenticatesRequests $login)
    {
        return $this->authenticationService->loginWeb($login);
    }

}
