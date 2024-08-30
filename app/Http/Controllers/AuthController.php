<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showAuthForm(){
        return view('auth');
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'city'=> 'required|string|max:255',
            'address'=> 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'password' => Hash::make($request->password),
        ]);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        //Verificar que los datos esten correctos y redireccionar a home
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // return redirect()->route('home');
            return response()->json(['success' => true]);

        }
        return response()->json(['errors' => ['email' => ['Las credenciales no coinciden con nuestros registros.']]], 422);
    }

    //Cerrar sesión 
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth');
    }
}
