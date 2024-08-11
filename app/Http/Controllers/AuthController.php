<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('username', $request->username)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan.',
                    'data' => null,
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kredensial tidak sah.',
                    'data' => null,
                ], 401);
            }

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil.',
                'data' => [
                    'token' => $token,
                    'admin' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'phone' => $user->phone,
                        'email' => $user->email,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan yang tidak terduga.',
                'data' => null,
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            $currentToken = $user->currentAccessToken();
            if ($currentToken) {
                $currentToken->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil logout.',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token tidak valid.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan yang tidak terduga.',
            ], 500);
        }
    }
}
