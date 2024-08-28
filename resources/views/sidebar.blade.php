<button id="open" class="open">
    <i class="fa-solid fa-bars"></i>
</button>
<div class="navegation" id="navegation">
    <button id="close" class="close">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="sidebar-head">
    <img src="img/pokeball.png" alt="pokeball">
    <span>
    {{ auth()->user()->name }}
    </span>
    </div>
    <ul class="nav-ul">
    <li class="close-link"><a href="{{route('home')}}"><i class="fa-solid fa-house"></i>Inicio</a></li> 
    <li class="close-link"><a href="{{route('products.create')}}"><i class="fa-solid fa-arrow-up-from-bracket"></i>Publicar</a>
    </li>  
    <li class="close-link"><a href="{{route('cart.index')}}"><i class="fa-solid fa-cart-shopping"></i>Carrito</a>
    </li>   
    <li class="close-link"><a href="{{route('products.adminproduct')}}"><i class="fa-solid fa-user-gear"></i>Administrador</a>
    </li>  
    <li class="close-link"><a href="{{route('sales.index')}}"><i class="fa-solid fa-file-invoice-dollar"></i>Ventas realizadas</a>
    </li>  
    <li class="close-link"><a href="{{route('buy.index')}}"><i class="fa-solid fa-shop"></i>Compras realizadas</a>
    </li>  
    <li class="close-link"><form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit"><i class="fa-solid fa-right-to-bracket"></i>Cerrar Sesión</button>
</form></li>  
    </ul>
</div> <!-- Fin de navegador -->


