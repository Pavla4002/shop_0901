<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">JewelryForU</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @guest()
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('registrationPage')}}">Регистрация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Авторизация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('welcome')}}">Главная</a>
                    </li>
                @endguest
                    @auth()
                        @if(\Illuminate\Support\Facades\Auth::user()->role==0)
                            <li class="nav-item">
                                <a class="nav-link" href="#">Мои заказы</a>
                            </li>
                        @elseif(\Illuminate\Support\Facades\Auth::user()->role==1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('menu_page_admin')}}">Админская</a>
                            </li>
                        @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('catalog_page')}}">Каталог</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{route('cart_page')}}">Корзина</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{route('order_page_user')}}">Мои заказы</a>
                                </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}">Выход</a>
                            </li>
                    @endauth
            </ul>
        </div>
    </div>
</nav>
