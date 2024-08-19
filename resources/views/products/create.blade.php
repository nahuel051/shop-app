<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar producto</title>
</head>
<body>
@include('sidebar')
<form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" required placeholder="Nombre de producto">
    <textarea name="description" placeholder="Descripción" required></textarea>
    <input type="number" step="0.01" name="price" required placeholder="Precio">
    <input type="number" name="quantity" required placeholder="Cantidad">
    <input type="file" name="img" required>
    <button type="submit">Publicar</button>
</form>
@if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif
</body>
</html>