<header class="header-section border-bottom">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-5 col-auto order-1">
                <div class="logo d-flex align-items-center justify-content-start">
                    <a href="{{ route('guest.home') }}" class="text">Tojir.loc</a>
                    <div class="hamburger hamburger-hmenu"><i class="fa fa-bars" aria-hidden="true"></i></div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 order-md-2 order-3 mt-3 mt-md-0">
                <div class="header-search">
                    <div class="input-group">
                        <input type="text" placeholder="Поиск">
                        <button type="button"><i class="ti-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-auto order-md-3 ml-auto order-2">
                <div class="mr-2">
                    <a href="{{ route('cart.index') }}">
                        <div class="cart-icon">
                            <img src="/img/cart.png" alt="Cart">
                            <div class="cart-count"><span>{{ Cart::count() }}</span></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
