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
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'phone_number' => $fields['phone_number'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken($user->name . 'apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->success($response);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'phone_number' => 'required|regex:/^((09))[0-9]{8}/',
            'password' => 'required|string'
        ]);

        //check phone number
        if ($request->filled('phone_number'))
            $user = User::where('phone_number', $fields['phone_number'])->first();

        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $token = $user->createToken($user->name . 'apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->success($response);
    }

    public function logout(Request $request) {
        auth()->user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'you have successfully been logged out'
        ]);
    }
}
