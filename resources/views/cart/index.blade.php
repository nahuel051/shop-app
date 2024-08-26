<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>
<body>
@include('sidebar')

<h1>Carrito de Compras</h1>
@if(session('cart') && count(session('cart')) > 0)
    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach(session('cart') as $id => $item)
    @php
        $product = App\Models\Product::find($id);
    @endphp
    <tr>
        <td><img src="{{ asset('storage/' . $item['img']) }}" alt="{{ $item['name'] }}" style="width: 50px; height: auto;"></td>
        <td>{{ $item['name'] }}</td>
        <td>{{ $item['quantity'] }}</td>
        <td>${{ $item['price'] }}</td>
        <td>${{ $item['total'] }}</td>
        <td>
            <form action="{{ route('cart.remove', $id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
@endforeach

        </tbody>
    </table>
    <br>
    <a href="{{ route('checkout.payment') }}">Proceder al Pago</a>
     @else
    <p>Tu carrito está vacío.</p>
@endif
<!-- Mostrar mensajes de error -->
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</body>
</html>