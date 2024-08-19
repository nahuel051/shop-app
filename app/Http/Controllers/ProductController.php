<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
        return view('index');
    }


        //CREAR PUBLICACION DE PRODUCTO
        public function create()
        {
            return view('products.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            //Almacenar la imagen en el sistema de archivos
            $imagePath = $request->file('img')->store('products', 'public');
    
            Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'img' => $imagePath,
                'user_id' => Auth::id(), //Guardar el id del usuario publicador
            ]);
    
            return redirect()->route('home');
        }

}
