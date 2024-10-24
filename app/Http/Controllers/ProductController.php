<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        // Recupera todos los productos de la base de datos
        $products = Product::all();
        // Retorna la vista 'index' con la lista de productos
        //view es una funcion que devuelve una vista al navegador
        //index nombre de vistsa
        //array asociativo: contiene los datos que se van a pasar, products' es la clave, y $products es la variable que contiene los datos que deseas enviar a la vista.
        //products es una colección de Eloquent (normalmente un conjunto de registros obtenidos de la base de datos) que contiene todos los productos. Se obtuvo previamente usando Product::all() en el controlador.
        //ejemplo en va vista: 
        //         @foreach ($products as $product)
        //     <div>
        //         <h2>{{ $product->name }}</h2>
        //         <p>{{ $product->description }}</p>
        //         <p>Precio: {{ $product->price }}</p>
        //     </div>
        // @endforeach
        return view('index', ['products' => $products]);
    }

    public function create()
    {
        // Retorna la vista del formulario para crear un nuevo producto
        return view('products.create');
    }

    // Almacenar una nueva publicación
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Almacenar la imagen en el sistema de archivos (en el disco 'public')
        $imagePath = $request->file('img')->store('products', 'public');
        // Crear un nuevo producto con los datos validados
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'img' => $imagePath,
            'user_id' => Auth::id(), // Guardar el id del usuario publicador
        ]);
        // Si la solicitud es AJAX, retorna una respuesta JSON
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        // Redirige al usuario a la ruta 'home'
        return redirect()->route('home');
    }

    // Mostrar detalles del producto
    public function show($id)
    {
        // Encuentra el producto por su id, si no existe, lanza un error 404
        $product = Product::findOrFail($id);
        // Retorna la vista con los detalles del producto
        return view('products.show', compact('product'));
    }

    // Agregar producto al carrito
    public function addToCart(Request $request, $id)
    {
        // Encuentra el producto por su id
        $product = Product::findOrFail($id);

        // Verifica si el producto tiene stock suficiente
        if ($product->quantity < $request->quantity) {
            // Si la cantidad solicitada es mayor que la cantidad disponible, se devuelve al usuario a la página anterior usando back() y se añade un mensaje de error usando withErrors().
            return back()->withErrors(['message' => 'No hay suficiente stock disponible.']);
        }

        // Verifica si el usuario está intentando comprar su propio producto
        if (Auth::id() === $product->user_id) {
            return back()->withErrors(['message' => 'No puedes comprar tu propio producto.']);
        }

        // Almacenar el artículo en el carrito en la sesión
        // Se obtiene el carrito de la sesión del usuario. Si no existe un carrito en la sesión, se inicializa como un array vacío [].
        $cart = session()->get('cart', []);

        $cart[$id] = [
            "name" => $product->name,
            "quantity" => $request->quantity,
            "price" => $product->price,
            "img" => $product->img,
            "total" => $product->price * $request->quantity,
        ];
// session()->put('cart', $cart): Después de agregar o actualizar el producto en el carrito, se guarda el carrito completo en la sesión del usuario.
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }



    // Mostrar vista del carrito de compras
    public function cart()
    {
        // Este método recupera el carrito almacenado en la sesión del usuario. Si no existe un carrito en la sesión, se inicializa como un array vacío [].
        $cart = session()->get('cart', []);

        // Depura el carrito para asegurarte de que contiene los productos correctos
        // Recorrer el carrito: Se itera sobre cada elemento del carrito usando un foreach.
        // $id: Es la clave del array, que representa el ID del producto en el carrito.
        // $item: Es el valor asociado a la clave $id, que contiene los detalles del producto en el carrito (nombre, cantidad, precio, etc.).
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
        // $product && $product->user_id === Auth::id(): Se comprueba si el producto fue encontrado y si pertenece al usuario autenticado
            if ($product && $product->user_id === Auth::id()) {
                // Eliminar productos del carrito que pertenecen al usuario
                unset($cart[$id]);
            }
        }
        // Después de depurar el carrito, se guarda el carrito actualizado en la sesión del usuario. Esto asegura que cualquier producto eliminado durante la depuración no permanezca en la sesión.
        session()->put('cart', $cart);

        return view('cart.index', compact('cart'));
    }



    // Eliminar artículo del carrito
    public function removeFromCart($id)
    {
        // Este método recupera el carrito actual almacenado en la sesión del usuario. Si el carrito no existe, devolverá null.
        $cart = session()->get('cart');
        // isset($cart[$id]): Aquí se comprueba si existe un producto en el carrito con el ID especificado ($id).
        // $id: Este parámetro es el identificador del producto que se desea eliminar del carrito.
        if (isset($cart[$id])) {
            // Si el producto con el ID especificado existe en el carrito, se elimina del array $cart utilizando unset(), que remueve la entrada correspondiente al producto del carrito.
            unset($cart[$id]);
            //  Después de eliminar el producto, se guarda el carrito actualizado en la sesión del usuario. Esto asegura que los cambios realizados (es decir, la eliminación del producto) se reflejen en la sesión.
            session()->put('cart', $cart);
        }
        // Redirige a la vista del carrito
        return redirect()->route('cart.index');
    }

    // Mostrar formulario de checkout
    public function checkout()
    {
        // Retorna la vista del formulario de pago
        return view('checkout.payment');
    }

    // Administrador de productos: listar los productos del usuario autenticado// Administrador de productos: listar los productos del usuario autenticado
    public function adminProduct()
    {
        //  El método where() filtra los productos cuya columna user_id coincide con el ID del usuario autenticado, que se obtiene mediante Auth::id().
        // get() ejecuta la consulta y obtiene todos los productos que pertenecen al usuario autenticado
        $products = Product::where('user_id', Auth::id())->get();
        // El método compact() crea un array asociativo que pasa la variable $products a la vista. Esto es equivalente a hacer ['products' => $products].
        return view('products.adminproduct', compact('products'));
    }


    // Mostrar el formulario de edición
    public function edit(Product $product)
    {
        // Verificar que el usuario tiene permiso para editar este producto
        if ($product->user_id !== Auth::id()) {
            //  Si la verificación falla, se redirige al usuario a la página de inicio (home) y se le muestra un mensaje de error indicando que no tiene autorización para acceder a esa acción.
            return redirect()->route('home')->withErrors('Acceso no autorizado');
        }

        return view('products.edit', compact('product'));
    }

    // Actualizar el producto
    public function update(Request $request, Product $product)
    {
        // Verificar que el usuario tiene permiso para actualizar este producto
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('home')->withErrors('Acceso no autorizado');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

    //$request->only(): Extrae solo los datos necesarios del Request para evitar manipulación accidental de otros campos.
    //Este array $data contendrá los valores de name, description, price, y quantity.
        $data = $request->only(['name', 'description', 'price', 'quantity']);

        // Si se proporciona una nueva imagen, guardarla en el sistema de archivos
        if ($request->hasFile('img')) {
        // Si se proporciona una imagen, se guarda en el sistema de archivos, dentro del directorio products del almacenamiento público. El path de la imagen se guarda en $data['img'].
            $data['img'] = $request->file('img')->store('products', 'public');
        }

        $product->update($data);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('products.adminproduct');
    }

    // Eliminar el producto
    public function destroy(Product $product)
    {
        // Verificar que el usuario tiene permiso para eliminar este producto
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('home')->withErrors('Acceso no autorizado');
        }
        // Elimina el producto de la base de datos. Esta operación es directa y elimina la fila correspondiente en la tabla products para el producto especificado.
        $product->delete();

        return redirect()->route('products.adminproduct');
    }
}
