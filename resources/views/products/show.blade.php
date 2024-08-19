<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
</head>

<body>
    @include('sidebar')

    <h1>{{ $product->name }}</h1>
    <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" style="width: 150px; height: auto;">
    <p>{{ $product->description }}</p>
    <p>Precio: ${{ $product->price }}</p>
    <p>Publicado por: {{ $product->user->name }}</p>

    @if($product->quantity > 0)
        <form action="{{ route('cart.add', $product->id) }}" method="post">
            @csrf
            <label for="quantity">Cantidad disponible: {{ $product->quantity }}</label>
            <input type="number" name="quantity" id="quantity" min="1" max="{{ $product->quantity }}" required>
            @if(Auth::id() !== $product->user_id)
                <button type="submit">Agregar al Carrito</button>
            @else
                <p>No puedes comprar tu propio producto.</p>
            @endif
        </form>
    @else
        <p style="color: red;">El producto no está disponible en stock.</p>
    @endif

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</body>

</html>