<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar producto</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
@include('sidebar')
<form id="productForm" action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" required placeholder="Nombre de producto">
    <textarea name="description" placeholder="Descripción" required></textarea>
    <input type="number" step="0.01" name="price" required placeholder="Precio">
    <input type="number" name="quantity" required placeholder="Cantidad">
    <input type="file" name="img" required>
    <button type="submit">Publicar</button>
</form>
<!-- @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif -->
<div id="errorContainer" style="color: red;"></div>

<script>
    $(document).ready(function() {
        $('#productForm').on('submit', function(e) {
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
                    window.location.href = "{{ route('home') }}";
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