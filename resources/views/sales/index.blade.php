@include('header')
<body>
<div class="container-content">
@include('sidebar')
<div class="content-shopping">
    <h2>Ventas realizadas</h2>
    <div class="table-container">
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Nombre Comprador</th>
                <th>Nombre Vendedor</th>
                <th>Método de Pago</th>
                <th>Total Venta</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->buyer ? $sale->buyer->name : 'Desconocido' }}</td>
                    <td>{{ $sale->seller ? $sale->seller->name : 'Desconocido' }}</td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>${{ $sale->details->sum('total') }}</td>
                    <td>
                        <a href="{{ route('sales.generatePdf', $sale->id) }}"><i class="fa-solid fa-file-pdf"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div> <!-- table-container -->
    </div> <!-- table-shopping -->
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
