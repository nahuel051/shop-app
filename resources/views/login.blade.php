<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form action="{{route('login')}}" method="post">
    @csrf
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <br>
    <button type="submit">Login</button>
    <a href="{{ route('register') }}">Register</a>
    <div id="error-messages"></div>
    </form>
    <!-- @if ($errors->any())
            <ul style="color: red">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    @endif -->
    <script>
        $(document).ready(function() {
            $("form").on("submit", function(event) {
                event.preventDefault(); // Prevenir el envío normal del formulario

                var form = $(this);
                var formData = form.serialize(); // Serializa los datos del formulario

                $.ajax({
                    url: form.attr("action"), // La URL del formulario
                    type: form.attr("method"), // El método del formulario
                    data: formData,
                    success: function(response) {
                        // Redirigir a la página principal si el inicio de sesión es exitoso
                        window.location.href = "{{ route('home') }}";
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = "";

                        $.each(errors, function(key, value) {
                            errorMessages += "<p>" + value[0] + "</p>"; // Construir el mensaje de error
                        });

                        $("#error-messages").html(errorMessages); // Mostrar los mensajes de error
                    }
                });
            });
        });
    </script>
</body>
</html>