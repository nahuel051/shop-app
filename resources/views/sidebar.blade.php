<a href="{{route('home')}}">Inicio</a>
<a href="{{route('products.create')}}">Publicar</a>
<a href="{{route('cart.index')}}">Carrito</a>
<a href="{{route('products.adminproduct')}}">Administrador</a>
<a href="{{route('sales.index')}}">Ventas realizadas</a>
<a href="{{route('buy.index')}}">Compras realizadas</a>

<form action="{{ route('auth') }}" method="POST">
    @csrf
    <button type="submit">Cerrar Sesión</button>
</form>