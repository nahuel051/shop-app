<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis productos</title>
</head>
<body>
    @include('sidebar')
    <table>
        <thead>
        <tr>
        <th>Nombre del producto</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Imágenes</th>
        <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>Price: ${{ $product->price }}</td>
            <td>Quantity: {{ $product->quantity }}</td>
            <td>
            <!-- Si el producto tiene imagen mostrar -->
            @if ($product->img)
            <!-- Usa la función asset de Blade para generar la URL completa de la imagen almacenada en el directorio storage. La ruta de la imagen se construye concatenando 'storage/' con el valor de $product->image. -->
                    <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" style="width: 150px; height: auto;">
                @endif
            </td>
            <td>
            <a href="{{ route('products.edit', $product->id) }}">Editar</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>