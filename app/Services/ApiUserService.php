<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiUserService
{
    public function registerUser(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  // Hash the password
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully ' . $request->name,
        ], 201);
    }
}
