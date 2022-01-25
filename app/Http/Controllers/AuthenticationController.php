<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPostRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    /**
     * Register a new user
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterPostRequest $request)
    {

        return $this->authenticationService->register($request->all());
    }

    public function login(Request $request)
    {
        dd($request->all());
    }

}
