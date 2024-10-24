@include('header')
<body>
<div class="container-content">
    @include('sidebar')
    <div class="content-create">
    <!-- enviar datos a la ruta products.update con el método POST. -->
    <form id="editForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- método PUT para la actualización de recursos. -->
        @method('PUT')
        <h2>Editar Producto</h2>
    <input type="text" name="name" value="{{ $product->name }}" required placeholder="Nombre de producto">
    <textarea name="description" placeholder="Descripción" required>{{ $product->description }}</textarea>
    <input type="number" step="0.01" name="price" required placeholder="Precio" value="{{ $product->price }}">
    <input type="number" name="quantity" required placeholder="Cantidad" value="{{ $product->quantity }}">
    <div class="file-input">
                    <input type="file" name="img">
                    <label for="foto_perfil">Seleccionar foto</label>
                    <span id="file-label">Ningún archivo seleccionado</span>
            </div>
    <button type="submit">Editar</button>
    </form>
    <div id="errorContainer"></div>
    </div> <!-- container-create -->
    </div> <!-- container-content -->
<script>
    $(document).ready(function() {
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this); //Obtiene el formulario actual.
            let url = form.attr('action'); //Obtiene la URL de acción del formulario.
            let formData = new FormData(this); // incluye los campos del formulario

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location.href = "{{ route('products.adminproduct') }}";
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function(key, value) {
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