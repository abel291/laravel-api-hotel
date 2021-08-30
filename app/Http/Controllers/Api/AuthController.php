<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        return $this->success([
            'token' => $user->createToken($attr['email'])->plainTextToken,
            'user' => $user
        ]);
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|string|email|',
    //         'password' => 'required|string|min:6'
    //     ]);
    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return $this->success([
    //             'user' => auth()->user()
    //         ]);
    //     } else {
    //         return $this->error('Estas credenciales no coinciden con nuestros registros.', 401);
    //     }
    // }
}
