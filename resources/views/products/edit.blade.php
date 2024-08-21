<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    @include('sidebar')
    <form id="editForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <input type="text" name="name" value="{{ $product->name }}" required placeholder="Nombre de producto">
    <textarea name="description" placeholder="Descripción" required>{{ $product->description }}</textarea>
    <input type="number" step="0.01" name="price" required placeholder="Precio" value="{{ $product->price }}">
    <input type="number" name="quantity" required placeholder="Cantidad" value="{{ $product->quantity }}">
    <input type="file" name="img">
    <button type="submit">Editar</button>
    </form>
    <div id="errorContainer" style="color: red;"></div>

<script>
    $(document).ready(function() {
        $('#editForm').on('submit', function(e) {
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
</script>
</body>
</html>