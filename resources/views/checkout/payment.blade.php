<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar pago</title>
</head>
<body>
@include('sidebar')

    <h1>Confirmar Pago</h1>
    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <label for="payment_method">Método de Pago:</label>
        <select name="payment_method" id="payment_method">
            <option value="mercado_pago">Mercado Pago</option>
            <option value="paypal">PayPal</option>
            <option value="visa">Visa</option>
        </select>
        <br><br>
        <button type="submit">Confirmar Pago</button>
    </form>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
