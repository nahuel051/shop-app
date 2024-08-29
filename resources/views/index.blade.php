@include('header')
<body>
    <div class="container-content">
            @include('sidebar')
        <div class="content-home">
            @foreach($products as $product)
                <div class="content-product">
                    @if ($product->img)
                        <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}">
                    @endif
                    <p>Precio: ${{ $product->price }}</p>
                    <a href="{{ route('products.show', $product->id) }}">Ver Detalle</a>
                </div>
            @endforeach
        </div><!-- content-home -->
    </div> <!-- container-content -->
    <script>
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