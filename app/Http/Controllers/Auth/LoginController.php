<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function cekEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'success' => $exists,
        ]);
    }

    public function cekPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $passwordMatches = $user && Hash::check($request->password, $user->password);

        return response()->json([
            'success' => $passwordMatches,
        ]);
    }
}
