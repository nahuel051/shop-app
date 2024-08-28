@include('header')

<body>
    <div class="container" id="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Formulario de Login -->
                <form id="loginForm" class="sign-in-form" action="{{ route('login') }}" method="post">
                    <h2>Iniciar Sesión</h2>
                    @csrf
                    <input type="email" name="email" required placeholder="Email">
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
                var form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function (response) {
                        window.location.href = "{{ route('home') }}";
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = "";
                        $.each(errors, function (key, value) {
                            errorMessages += "<p>" + value[0] + "</p>";
                        });
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
                        window.location.href = "{{ route('home') }}";
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