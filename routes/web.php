<?php

use App\Http\Controllers\BuyReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleReportController;

Route::get('/', function () {
    return view('welcome');
});

//REGISTRO E INICIO DE SESIÓN
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', function() {
    return redirect()->route('auth');
});
Route::get('/register', function() {
    return redirect()->route('auth');
});
Route::get('/logout', function() {
    return redirect()->route('auth');
});

// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    //PAGINA PRINCIPAL
    Route::get('/home', [ProductController::class, 'index'])->name('home');

    //PUBLICAR PRODUCTO
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); //Formulario de creacion
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); //Procesa los datos y lo guarda en la base de datos.

    //DETALLE DE PRODUCTO
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    //Ruta para agregar al carrito
    Route::post('/cart/{id}', [ProductController::class, 'addToCart'])->name('cart.add');

    //CARRITO DE COMPRAS
    Route::get('/cart', [ProductController::class, 'cart'])->name('cart.index');
    //Eliminar articulo del carrito
    Route::delete('/cart/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

    //CHECKOUT
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout.index');
    Route::get('/checkout/payment', [PaymentController::class, 'showPaymentForm'])->name('checkout.payment');
    Route::post('/checkout/payment', [PaymentController::class, 'processPayment'])->name('payment.process');

    //ADMINISTRADOR DE PRODUCTOS
    // Ruta para listar los productos del usuario
    Route::get('/products', [ProductController::class, 'adminProduct'])->name('products.adminproduct');
    // Rutas para editar y actualizar productos
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    // Ruta para eliminar productos
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    //SALE
    Route::get('/sales', [SaleReportController::class, 'index'])->name('sales.index');
    Route::get('/sales/pdf/{saleId}', [SaleReportController::class, 'generatePdf'])->name('sales.generatePdf');

    //REPORTE
    Route::get('/buy', [BuyReportController::class, 'index'])->name('buy.index');
    Route::get('/buy/pdf/{buyId}', [BuyReportController::class, 'generatePdf'])->name('buy.generatePdf');
});
