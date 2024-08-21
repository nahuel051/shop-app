<!DOCTYPE html>
<html>
<head>
    <title>Nota de compra</title>
    <style>
        /* Aquí puedes agregar estilos para el PDF */
    </style>
</head>
<body>
    <h1>Nota de compra</h1>
    <p><strong>ID Venta:</strong> {{ $buy->id }}</p>
    <p><strong>Comprador:</strong> {{ $buyer->name }}</p>
    <p><strong>Vendedor:</strong> {{ $seller->name }}</p>
    <p><strong>Método de Pago:</strong> {{ $buy->payment_method }}</p>
    <p><strong>Total de compra:</strong> ${{ $buy->total }}</p>

    <h2>Detalles de la compra</h2>
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
