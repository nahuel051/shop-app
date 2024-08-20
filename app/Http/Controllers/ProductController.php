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

    //Almacenar el arituclo en el carrito en la sesión
    $cart = session()->get('cart', []);

    $cart[$id] = [
        "name" => $product->name,
        "quantity" => $request->quantity,
        "price" => $product->price,
        "img" => $product->img,
        "total" => $product->price * $request->quantity,
    ];

    session()->put('cart', $cart);

    return redirect()->route('cart.index');
}
//Vista del carrito de compras
public function cart()
{
    $cart = session()->get('cart', []);
    return view('cart.index', compact('cart'));
}
public function removeFromCart($id)
{
    $cart = session()->get('cart');

    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->route('cart.index');
}
//Procesar a pagar el pago
public function checkout()
{
    return view('checkout.payment');
}

}
