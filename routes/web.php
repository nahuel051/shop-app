<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

