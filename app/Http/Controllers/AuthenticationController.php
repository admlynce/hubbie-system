<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

}
