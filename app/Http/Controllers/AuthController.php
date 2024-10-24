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
            'password' => 'required|string|confirmed|min:8', //confirmada (verifica que coincida con el campo `password_confirmation`)
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'password' => Hash::make($request->password), // Cifra la contraseña antes de almacenarla
        ]);

        // Si la solicitud es AJAX, devuelve una respuesta JSON de éxito
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
        // Si la autenticación es exitosa, devuelve una respuesta JSON de éxito
            return response()->json(['success' => true]);

        }
        // Si la autenticación falla, devuelve una respuesta JSON con un error
        return response()->json(['errors' => ['email' => ['Las credenciales no coinciden con nuestros registros.']]], 422);
    }

    //Cerrar sesión 
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth');
    }
}
