<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $user = $this->userService->register($request);
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function signIn(Request $request)
    {
        try{
            $token = $this->userService->signIn($request);
        } catch(\Exception $e){
            response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['access_token' => $token]);
    }


    public function recoverPassword(Request $request)
    {
        try{
            $this->userService->recoverPassword($request);
        } catch(\Exception $e){
            response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Password reset link sent to email.']);
    }
}

