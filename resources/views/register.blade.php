<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <form action="{{route('register')}}" method="post">
        @csrf
        <input type="text" name="name" required placeholder="Nombre y apellido">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Contraseña">
        <input type="text" name="city" required placeholder="Ciudad">
        <input type="text" name="address" required placeholder="Dirección">
        <input type="password" name="password_confirmation" required placeholder="Repetir contraseña">
        <br>
        <button type="submit">Registrar</button>
    </form>
    <a href="{{route('login')}}">Login</a>
    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif
</body>
</html>