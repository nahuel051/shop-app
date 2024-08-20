<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
</head>
<body>
    @include('sidebar')
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <input type="text" name="name" value="{{ $product->name }}" required placeholder="Nombre de producto">
    <textarea name="description" placeholder="Descripción" required>{{ $product->description }}</textarea>
    <input type="number" step="0.01" name="price" required placeholder="Precio" value="{{ $product->price }}">
    <input type="number" name="quantity" required placeholder="Cantidad" value="{{ $product->quantity }}">
    <input type="file" name="img">
    <button type="submit">Editar</button>
    </form>
</body>
</html>