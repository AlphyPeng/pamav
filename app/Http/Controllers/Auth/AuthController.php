<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'employee_id' => 'required|string',
            'password'    => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $request->session()->regenerate();

        $user = $request->user();

        return response()->json([
            'message' => 'Login successful.',
            'user'    => [
                'employee_id' => $user->employee_id,
                'name'        => $user->name,
            ]
        ]);
    }

    public function logout(Request $request) {}
}
