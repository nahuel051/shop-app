@include('header')
<body>
<div class="container-content">
    @include('sidebar')
    <div class="content-detail">
    <h2>{{ $product->name }}</h2>
    <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" style="width: 150px; height: auto;">
    <p>{{ $product->description }}</p>
    <p>Precio: ${{ $product->price }}</p>
    <p>Publicado por: {{ $product->user->name }}</p>

    @if($product->quantity > 0)
        <form action="{{ route('cart.add', $product->id) }}" method="post">
            @csrf
            <div class="content-quantiy">
            <label for="quantity">Cantidad disponible: {{ $product->quantity }}</label>
            <input type="number" name="quantity" id="quantity" min="1" max="{{ $product->quantity }}" required>
            </div>
            @if(Auth::id() !== $product->user_id)
                <button type="submit">Agregar al Carrito</button>
            @else
                <p>No puedes comprar tu propio producto.</p>
            @endif
        </form>
    @else
        <p style="color: red;">El producto no está disponible en stock.</p>
    @endif

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    </div> <!-- content-detail -->
    </div> <!-- table-container -->
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