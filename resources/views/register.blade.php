<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="registerForm" action="{{route('register')}}" method="post">
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
    <!-- @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif -->
<div id="errorMessages" style="color: red;"></div>
<script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(event) {
                event.preventDefault(); // Evita el envío del formulario

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        window.location.href = "{{ route('login') }}"; // Redirige al login si el registro es exitoso
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>'; // Muestra el primer mensaje de error de cada campo
                        });
                        errorHtml += '</ul>';
                        $('#errorMessages').html(errorHtml); // Muestra los errores en el div
                    }
                });
            });
        });
    </script>
</body>
</html>