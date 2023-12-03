<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|regex:/^((09))[0-9]{8}/|unique:users,phone_number',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'phone_number' => $fields['phone_number'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'phone_number' => 'required_if:email,null|regex:/^((09))[0-9]{8}/',
            'email' => 'required_if:phone_number,null|string',
            'password' => 'required|string'
        ]);

        //check email
        if ($request->filled('email'))
            $user = User::where('email', $fields['email'])->first();

        //check phone number
        if ($request->filled('phone_number'))
            $user = User::where('phone_number', $fields['phone_number'])->first();

        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => "Logged Out"
        ];
    }
}
