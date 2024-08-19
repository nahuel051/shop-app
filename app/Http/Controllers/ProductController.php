<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        // Obtener todos los productos de la base de datos
        $products = Product::all();

        // Pasar los productos a la vista 'index'
        return view('index', ['products' => $products]);
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

//Mostrar detalled e producto
    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
}

public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Verifica si el producto tiene stock suficiente
    if ($product->quantity < $request->quantity) {
        return back()->withErrors(['message' => 'No hay suficiente stock disponible.']);
    }

    // Verifica si el usuario está intentando comprar su propio producto
    if (Auth::id() === $product->user_id) {
        return back()->withErrors(['message' => 'No puedes comprar tu propio producto.']);
    }

    // Lógica para agregar el producto al carrito (pendiente de implementar)
    // ...

    return redirect()->route('cart.index');
}


}
