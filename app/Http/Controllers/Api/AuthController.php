<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Register Logic
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'phone'    => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => Hash::make($data['password']),
            // Default role 'user' hoga, admin aap manually DB mein change kar sakte hain
            'role'     => 'user',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    // 2. Login Logic
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string'
        ]);

        // User find karein
        $user = User::where('email', $fields['email'])->first();

        // Password check karein
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        // Token create karein
        $token = $user->createToken('auth_token')->plainTextToken;

        // Frontend (React) ko user details aur token dono bhejein
        return response()->json([
            'status'  => 'success',
            'message' => 'Login Successful',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role, // Yahi React mein use hoga (admin vs user)
            ],
            'token'   => $token,
        ], 200);
    }

    // 3. Logout Logic
    public function logout(Request $request)
    {
        // Current token delete karein
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // 4. Get User Data (Auth Check)
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
