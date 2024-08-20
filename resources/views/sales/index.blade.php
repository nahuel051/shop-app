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
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->user ? $sale->user->name : 'Desconocido' }}</td>
                    <td>
                        @if ($sale->details->isNotEmpty() && $sale->details->first()->product->user)
                            {{ $sale->details->first()->product->user->name }}
                        @else
                            Desconocido
                        @endif
                    </td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>${{ $sale->details->sum(function($detail) { return $detail->total; }) }}</td>
                    <td>
                        <a href="{{ route('sales.generatePdf', $sale->id) }}">Nota de Venta</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
