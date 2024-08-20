<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buy;
use App\Models\DetailsBuy;
use App\Models\Sale;
use App\Models\DetailsSale;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        $cart = session()->get('cart', []);
        return view('checkout.payment', compact('cart'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:mercado_pago,paypal,visa',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Tu carrito está vacío.');
        }

        // Calcular el total de la compra/venta
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
        }

        // Crear la entrada en la tabla 'buy'
        $buy = Buy::create([
            'user_id' => $product->user_id, // Aquí se registra el vendedor
            'total' => $total,
        ]);

        // Crear la entrada en la tabla 'sale'
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'payment_method' => $request->payment_method,
            'total' => $total,
        ]);

        // Almacenar detalles de la compra y venta
        foreach ($cart as $id => $item) {
            // Insertar en 'details_buy'
            DetailsBuy::create([
                'buy_id' => $buy->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);

            // Insertar en 'details_sale'
            DetailsSale::create([
                'sale_id' => $sale->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);

            // Actualizar el stock del producto
            $product = Product::find($id);
            $product->quantity -= $item['quantity'];
            $product->save();
        }

        // Limpiar el carrito
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Pago realizado con éxito.');
    }
}
