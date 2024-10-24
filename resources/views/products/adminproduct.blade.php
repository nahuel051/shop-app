@include('header')
<body>
<div class="container-content">
    @include('sidebar')
    <div class="content-adm">
    <h2>Administrador de productos</h2>
    <div class="table-container">
    <table class="styled-table">
        <thead>
        <tr>
        <th>Nombre del producto</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Imágenes</th>
        <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
    <!-- Itera la colección de productos -->
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>Price: ${{ $product->price }}</td>
            <td>Quantity: {{ $product->quantity }}</td>
            <td>
            <!-- Si el producto tiene imagen mostrar -->
            @if ($product->img)
            <!-- Usa la función asset de Blade para generar la URL completa de la imagen almacenada en el directorio storage. La ruta de la imagen se construye concatenando 'storage/' con el valor de $product->image. -->
                    <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" style="width: 150px; height: auto;">
                @endif
            </td>
            <td>
            <div class="content-action">
            <a href="{{ route('products.edit', $product->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
            <!-- Envía una solicitud DELETE a la ruta de eliminación. -->
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    <!-- método de solicitud es DELETE. -->
                    @method('DELETE')
                    <button type="submit"><i class="fa-solid fa-trash"></i></button>
                </form>
                </div> <!-- content-action -->
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div> <!-- table-container -->
    </div> <!-- content-adm -->
    </div> <!-- container-content -->
    <script>
        const nav = document.querySelector("#navegation");
        const abrir = document.querySelector("#open");
        const cerrar = document.querySelector("#close");
        const cerrarLinks = document.querySelectorAll(".close-link");

        abrir.addEventListener("click", () => {
            nav.classList.add("visible");
            console.log("Navegación abierta"); 
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