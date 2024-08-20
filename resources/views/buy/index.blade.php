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
                <th>ID Compra</th>
                <th>Total Compra</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buys as $buy)
                <tr>
                    <td>{{ $buy->id }}</td>
                    <td>${{ $buy->details->sum('total') }}</td>
                    <td>
                        <a href="{{ route('buy.generatePdf', $buy->id) }}">Nota de Compra</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
