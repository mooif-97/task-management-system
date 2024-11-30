<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class TokenController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('user_id', $request['user_id'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            // User not found or password mismatch
            return response()->json([
                'message' => 'User ID or password are incorrect.',
            ], 401);
        }

        $token = $user->createToken('TaskManagementToken')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
