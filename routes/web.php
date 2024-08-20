<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleReportController;

Route::get('/', function () {
    return view('welcome');
});

//Registro e Inicio de sesión
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//Pagina principal
Route::get('/home', [ProductController::class, 'index'])->name('home')->middleware('auth');

//Publicar producto
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth'); //Formulario de creacion
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth'); //Procesa los datos y lo guarda en la base de datos.

//Detalle de producto
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
//Ruta para agregar al carrito
Route::post('/cart/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
//Mostrar carrito
Route::get('/cart', [ProductController::class, 'cart'])->name('cart.index');
//Eliminar articulo del carrito
Route::delete('/cart/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
//Ruta para checkout
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout.index');

Route::get('/checkout/payment', [PaymentController::class, 'showPaymentForm'])->name('checkout.payment');
Route::post('/checkout/payment', [PaymentController::class, 'processPayment'])->name('payment.process');

//Administrador de productos
// Ruta para listar los productos del usuario
Route::get('/products', [ProductController::class, 'admin_product'])->name('products.adminproduct')->middleware('auth');

// Rutas para editar y actualizar productos
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('auth');

// Ruta para eliminar productos
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');


Route::get('/sales', [SaleReportController::class, 'index'])->name('sales.index');
Route::get('/sales/pdf/{saleId}', [SaleReportController::class, 'generatePdf'])->name('sales.generatePdf');
