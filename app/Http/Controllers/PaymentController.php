<?php
// PaymentController:
// Verifica nuevamente que todos los productos en el carrito sean del mismo vendedor antes de procesar el pago.
// Registra tanto la compra (Buy) como la venta (Sale) y sus detalles, actualiza el stock, y luego limpia el carrito.
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
        // Validar método de pago
        $request->validate([
            'payment_method' => 'required|string|in:mercado_pago,paypal,visa',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Tu carrito está vacío.');
        }

        // Verificar que todos los productos en el carrito pertenecen al mismo vendedor
        $sellerId = Product::find(array_key_first($cart))->user_id;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product->user_id !== $sellerId) {
                return redirect()->route('cart.index')->withErrors('Todos los productos en el carrito deben ser del mismo vendedor.');
            }
        }

        // Calcular el total de la compra/venta
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Crear la entrada en la tabla 'buy'
        $buy = Buy::create([
            'user_id_seller' => $sellerId, // Se registra el vendedor
            'user_id_buyer' => Auth::id(),  // Se registra el comprador
            'payment_method' => $request->payment_method,
            'total' => $total,
        ]);

        // Crear la entrada en la tabla 'sale'
        $sale = Sale::create([
            'user_id_seller' => $sellerId, // Se registra el vendedor
            'user_id_buyer' => Auth::id(),  // Se registra el comprador
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
