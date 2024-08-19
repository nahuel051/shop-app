<a href="{{route('home')}}">Inicio</a>
<a href="{{route('products.create')}}">Publicar</a>
<a href="{{route('cart.index')}}">Carrito</a>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Cerrar Sesión</button>
</form>