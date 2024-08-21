<!DOCTYPE html>
<html>
<head>
    <title>Ventas realizadas</title>
</head>
<body>
@include('sidebar')
    <h1>Ventas realizadas</h1>
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
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->buyer ? $sale->buyer->name : 'Desconocido' }}</td>
                    <td>{{ $sale->seller ? $sale->seller->name : 'Desconocido' }}</td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>${{ $sale->details->sum('total') }}</td>
                    <td>
                        <a href="{{ route('sales.generatePdf', $sale->id) }}">Nota de Venta</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
