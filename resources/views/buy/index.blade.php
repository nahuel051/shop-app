<!DOCTYPE html>
<html>
<head>
    <title>Compras realizadas</title>
</head>
<body>
    @include('sidebar')
    <h1>Compras realizadas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Nombre Comprador</th>
                <th>Nombre Vendedor</th>
                <th>Método de Pago</th>
                <th>Total Venta</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buys as $buy)
                <tr>
                    <td>{{ $buy->id }}</td>
                    <td>{{ $buy->buyer ? $buy->buyer->name : 'Desconocido' }}</td>
                    <td>
                        {{ $buy->seller ? $buy->seller->name : 'Desconocido' }}
                    </td>
                    <td>{{ $buy->payment_method }}</td>
                    <td>${{ $buy->details->sum('total') }}</td> <!-- Cambiar detailsBuy a details -->
                    <td>
                        <a href="{{ route('buy.generatePdf', $buy->id) }}">Nota de Compra</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
