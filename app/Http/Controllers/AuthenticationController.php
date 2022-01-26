<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Login authentication user
     *
     * @return RedirectResponse
     */
    public function login(LoginPostRequest $request)
    {
        return $this->authenticationService->loginWeb($request->validated());
    }

    /**
     * Register a new user
     *
     * @return Response
     */
    public function register(RegisterPostRequest $request)
    {
        return $this->authenticationService->registerWeb($request->validated());
    }

    public function home(Request $request)
    {
        if ($request->has('ref')) {
            $this->authenticationService->setSessionReferrer($request->query('ref'));
        }

        return view('public/home');
    }
}
