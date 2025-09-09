<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Web Login (stateful - menggunakan session)
    public function webLogin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        
        // Untuk web API, juga menggunakan token untuk konsistensi
        $token = $user->createToken('web-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
            'message' => 'Login successful'
        ]);
    }

    // Mobile Login (stateless - menggunakan token)
    public function mobileLogin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['required', 'string']
        ]);

        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        
        // Hapus token lama untuk device yang sama (optional)
        $user->tokens()->where('name', $credentials['device_name'])->delete();
        
        $token = $user->createToken($credentials['device_name'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // Register untuk mobile
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'device_name' => ['required', 'string']
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    // Profile
    public function profile(Request $request) {
        return response()->json(['user' => $request->user()]);
    }

    // Logout
    public function logout(Request $request) {
        // Karena kedua API (web & mobile) menggunakan token, logout sama saja
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Token revoked successfully']);
    }
}
