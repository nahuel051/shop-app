<!DOCTYPE html>
<html>
<head>
    <title>Nota de Venta</title>
    <style>
        /* Aquí puedes agregar estilos para el PDF */
    </style>
</head>
<body>
    <h1>Nota de Venta</h1>
    <p><strong>ID Venta:</strong> {{ $buy->id }}</p>
    <p><strong>Total de Venta:</strong> ${{ $buy->total }}</p>

    <h2>Detalles de la Venta</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>${{ $detail->total / $detail->quantity }}</td>
                    <td>${{ $detail->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
