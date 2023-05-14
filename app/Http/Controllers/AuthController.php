<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return response()->json([
            'user' => $request->user(),
            'token' => $request->user()->createToken('api-token')->plainTextToken
        ],200);
    }
}
