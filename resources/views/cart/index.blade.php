@include('header')
<body>
<div class="container-content">
@include('sidebar')
<div class="content-cart">
<h2>Carrito de Compras</h2>
@if(session('cart') && count(session('cart')) > 0)
<div class="table-container">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach(session('cart') as $id => $item)
    @php
        $product = App\Models\Product::find($id);
    @endphp
    <tr>
        <td><img src="{{ asset('storage/' . $item['img']) }}" alt="{{ $item['name'] }}" style="width: 50px; height: auto;"></td>
        <td>{{ $item['name'] }}</td>
        <td>{{ $item['quantity'] }}</td>
        <td>${{ $item['price'] }}</td>
        <td>${{ $item['total'] }}</td>
        <td>
            <form action="{{ route('cart.remove', $id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit"><i class="fa-solid fa-xmark"></i></button>
            </form>
        </td>
    </tr>
@endforeach

        </tbody>
    </table> <!-- table-container -->
    </div> 
    <br>
    <a href="{{ route('checkout.payment') }}">Proceder al Pago</a>
     @else
    <p>Tu carrito está vacío.</p>
@endif
<!-- Mostrar mensajes de error -->
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>
</div> <!-- content-cart -->
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