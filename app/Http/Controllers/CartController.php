<?php
// CartController:
// Verifica que los productos añadidos al carrito sean del mismo vendedor.
// Permite la gestión del carrito (agregar, eliminar, vaciar).
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (!empty($cart)) {
            // Obtener el ID del vendedor del primer producto en el carrito
            $existingSellerId = Product::find(array_key_first($cart))->user_id;

            // Verificar si el producto que se está agregando es del mismo vendedor
            if ($product->user_id !== $existingSellerId) {
                return redirect()->back()->withErrors('Solo puedes agregar productos del mismo vendedor al carrito.');
            }
        }

        // Agregar el producto al carrito
        if (isset($cart[$productId])) {
            // Incrementar la cantidad si el producto ya está en el carrito
            $cart[$productId]['quantity'] += $request->input('quantity', 1);
        } else {
            // Agregar el producto al carrito si no está en el carrito
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $request->input('quantity', 1),
                "price" => $product->price,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito con éxito.');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito con éxito.');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado con éxito.');
    }
}
