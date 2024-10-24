@include('header')

<body>
    <div class="container" id="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Formulario de Login -->
                <!-- La acción se establece en la ruta login, que se define en (web.php) y se usa el método POST para enviar los datos del formulario. -->
                <form id="loginForm" class="sign-in-form" action="{{ route('login') }}" method="post">
                    <h2>Iniciar Sesión</h2>
                    @csrf 
                    <!-- Se incluye el token CSRF para proteger contra ataques de falsificación de solicitudes entre sitios -->
                    <input type="email" name="email" required placeholder="Email" autocomplete="off">
                    <input type="password" name="password" required placeholder="Password">
                    <br>
                    <button type="submit">Login</button>
                    <div id="loginErrorMessages"></div>
                </form>
                <!-- Formulario de Registro -->
                <form id="registerForm" class="sign-up-form" action="{{ route('register') }}" method="post">
                    <h2>Registrar</h2>
                    @csrf
                    <input type="text" name="name" required placeholder="Nombre y apellido">
                    <input type="email" name="email" required placeholder="Email">
                    <input type="text" name="city" required placeholder="Ciudad">
                    <input type="text" name="address" required placeholder="Dirección">
                    <input type="password" name="password" required placeholder="Contraseña">
                    <input type="password" name="password_confirmation" required placeholder="Repetir contraseña">
                    <br>
                    <button type="submit">Registrar</button>
                    <div id="registerErrorMessages"></div>
                </form>
            </div> <!--signin-signup" -->
        </div> <!--forms-container -->


        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h1>Registrate!</h1>
                    <button class="btn transparent" id="sign-up-btn">Registrarse</button>
                </div> <!-- content -->
            </div> <!-- panel left-panel -->
            <div class="panel right-panel">
                <div class="content">
                    <h1>Bienvenido!</h1>
                    <button class="btn transparent" id="sign-in-btn">Iniciar Sesión</button>
                </div> <!-- content -->
            </div> <!--panel right-panel -->
        </div> <!--panels-container -->
    </div> <!--container -->
    <script>
        $(document).ready(function () {
            // Manejar formulario de login
            $('#loginForm').on('submit', function (event) {
                event.preventDefault();
                var form = $(this); // Obtiene el formulario actual

                $.ajax({
                    url: form.attr('action'),  // URL a la que se enviarán los datos del formulario (ruta de login)
                    type: form.attr('method'), // Método de envío del formulario (POST)
                    data: form.serialize(), // Serializa los datos del formulario en formato URL-encoded
                    success: function (response) {
                    // Si la solicitud es exitosa, redirige al usuario a la página de inicio
                        window.location.href = "{{ route('home') }}";
                    },
                    error: function (xhr) {
                        // Si ocurre un error, procesa la respuesta del servidor
                        var errors = xhr.responseJSON.errors; // Obtiene los errores del JSON de respuesta
                        var errorMessages = ""; // Variable para almacenar los mensajes de error
                        $.each(errors, function (key, value) {
                        // Itera sobre los errores y los agrega a la variable errorMessages
                        // value[0]: Accede al primer mensaje de error en el array para el campo actual
                        // Para el campo email, value[0] accedería a "El campo email es obligatorio.".
                        // Para el campo password, value[0] accedería a "La contraseña es demasiado corta.".
                        errorMessages += "<p>" + value[0] + "</p>";
                        });
                        // Actualiza el contenido del div con id "loginErrorMessages" con los mensajes de error
                        $("#loginErrorMessages").html(errorMessages);
                    }
                });
            });

            // Manejar formulario de registro
            $('#registerForm').on('submit', function (event) {
                event.preventDefault();
                var form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        window.location.href = "{{ route('auth') }}";
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<ul>';
                        $.each(errors, function (key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul>';
                        $('#registerErrorMessages').html(errorHtml);
                    }
                });
            });
        });

        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>
</body>

</html>