<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Guid\Fields;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => ['string', 'required'],
            'email' => ['email', 'required', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create(
            [
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
            ]
        );
        $token = $user->createToken('rest_token')->plainTextToken;
        $respone = [
            'user' => $user,
            'token' => $token,
        ];
        return $respone;
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'logged out successfully'
        ];
    }

    public function login(Request $request)
    {

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response([
                'message' => 'wrong credentials',
            ], 401);
        }
        // $request->session()->regenerate();
        // return redirect('/')->with('success','logged in successfully');
        $token = $user->createToken('rest_token')->plainTextToken;
        $respone = [
            'user' => $user,
            'token' => $token,
        ];
        return $respone;
    }
    // /return back()->withErrors(['email' => 'invalid credentials'])->onlyInput('email');

}
