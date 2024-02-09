<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        // return response($user,200);
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $authUser = auth()->attempt($request->only('email', 'password'));
        $user = auth()->user();

        if (!$authUser) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        } else {
            $token = auth()->user()->createToken('myapptoken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
        };
        return response($response, 201);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
