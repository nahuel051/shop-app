@include('header')
<body>
<div class="container-content">
@include('sidebar')
<div class="content-payment">
    <h2>Confirmar Pago</h2>
    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <label for="payment_method">Método de Pago:</label>
        <select name="payment_method" id="payment_method" class="custom-select">
            <option value="mercado_pago">Mercado Pago</option>
            <option value="paypal">PayPal</option>
            <option value="visa">Visa</option>
        </select>
        <br><br>
        <button type="submit">Confirmar Pago</button>
    </form>
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
