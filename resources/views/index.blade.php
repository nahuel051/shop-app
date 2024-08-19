<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body>
    @include('sidebar')
    @foreach($products as $product)
        <div>
            @if ($product->img)
                <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}"
                    style="width: 150px; height: auto;">
            @endif
            <p>Precio: ${{ $product->price }}</p>
            <a href="{{ route('products.show', $product->id) }}">Ver Detalle</a>
        </div>
    @endforeach
</body>
</html>