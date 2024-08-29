@include('header')
<body>
    <div class="container-content">
        @include('sidebar')
        <div class="content-create">
        <form id="productForm" action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h2>Publicar Producto</h2>
            <input type="text" name="name" required placeholder="Nombre de producto">
            <textarea name="description" placeholder="Descripción" required></textarea>
            <input type="number" step="0.01" name="price" required placeholder="Precio">
            <input type="number" name="quantity" required placeholder="Cantidad">
            <div class="file-input">
                    <input type="file" name="img" required>
                    <label for="foto_perfil">Seleccionar foto</label>
                    <span id="file-label">Ningún archivo seleccionado</span>
            </div>
            <button type="submit">Publicar</button>
        </form>
        <div id="errorContainer"></div>
        </div> <!-- container-create -->
    </div> <!-- container-content -->

    <script>
        $(document).ready(function () {
            $('#productForm').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        window.location.href = "{{ route('home') }}";
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '<ul>';
                        $.each(errors, function (key, value) {
                            errorHtml += '<li>' + value[0] + '</li>'; // Muestra el primer mensaje de error de cada campo
                        });
                        errorHtml += '</ul>';
                        $('#errorContainer').html(errorHtml);
                    }
                });
            });
        });

        const nav = document.querySelector("#navegation");
        const abrir = document.querySelector("#open");
        const cerrar = document.querySelector("#close");
        const cerrarLinks = document.querySelectorAll(".close-link");

        abrir.addEventListener("click", () => {
            nav.classList.add("visible");
            console.log("Navegación abierta"); // Agrega un mensaje para depuración
        });

        cerrar.addEventListener("click", () => {
            nav.classList.remove("visible");
        });

        cerrarLinks.forEach(link => {
            link.addEventListener("click", () => {
                nav.classList.remove("visible");
            });
        });
    </script>
</body>

</html>