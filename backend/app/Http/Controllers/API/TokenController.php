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
            'password' => 'required|string',
        ]);

        // TODO: password encrypt/decrypt
        // $encryptedPassword = $request->password;

        // Decrypt the password using the shared secret key
        // $decryptedPassword = openssl_decrypt(
        //     base64_decode($encryptedPassword), // The encrypted password is base64 encoded
        //     'aes-128-cbc', // AES encryption method
        //     env('PASSWORD_AES_SECRET_KEY'), // The secret key (must match the one used on the frontend)
        //     0, // No options
        //     env('AES_IV') // Initialization vector (IV) if used
        // );

        $user = User::where('user_id', $request['user_id'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            // User not found or password mismatch
            return response()->json([
                'message' => 'Incorrect User ID or password.',
            ], 401);
        }

        $token = $user->createToken('TaskManagementToken')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
