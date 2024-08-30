<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota de Venta</title>
    <style>
table{
    border-collapse: collapse; 
}

td{
    border: 1px solid #ddd;
    padding: 8px;
}

table th {
    background-color: black;
    color: white;
    text-align: left;
}

    </style>
</head>
<body>
    <h1>Nota de Venta</h1>
    <p><strong>ID Venta:</strong> {{ $sale->id }}</p>
    <p><strong>Comprador:</strong> {{ $buyer->name }}</p>
    <p><strong>Vendedor:</strong> {{ $seller->name }}</p>
    <p><strong>Método de Pago:</strong> {{ $sale->payment_method }}</p>
    <p><strong>Total de Venta:</strong> ${{ $sale->total }}</p>

    <h2>Detalles de la Venta</h2>
    <table>
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
