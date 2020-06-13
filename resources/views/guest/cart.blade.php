@extends('layout')
@section('content')
    <div class="container py-4">
        <div>
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-9">
                @if(Cart::count() > 0)
                    <h4 class="mb-4">{{ Cart::count() }} товар(ов) в корзине</h4>
                    <table class="table">
                        <tbody>
                            @foreach (Cart::content() as $product)
                                <tr>
                                    <td class="text-center">
                                        <a href="{{ route('guest.product', $product->model->id) }}"><img height="100px" src="{{ $product->model->full_path_to_image() }}" alt="..."></a>
                                    </td>
                                    <td><a class="text-dark" href="{{ route('guest.product', $product->model->id) }}">{{ $product->model->name }}</a></td>
                                    <td class="text-center">
                                        <div class="mb-1">
                                            <select class="quantity" data-id="{{ $product->rowId }}" data-productQuantity="{{ $product->model->quantity }}">
                                                @for ($i = 1; $i < 6; $i++)
                                                    <option {{ $product->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <form action="{{ route('cart.destroy', $product->rowId) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-link text-dark p-0">удалить</button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <h5 class="mb-1">{{ $product->subtotal }}</h5>
                                        <span>сом.</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row bg-light py-4 mb-4">
                        <div class="col-sm-7 mb-2">Доставка бесплатная, потому что мы такие классные.</div>
                        <div class="col-sm-5">
                            <div class="row mx-0">
                                <h5 class="mr-3">Итог</h5>
                                <h5 class="ml-sm-auto">{{ Cart::subtotal() }} сом.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto mr-sm-auto mb-3 mb-sm-0">
                            <a href="{{ route('guest.home') }}" class="btn btn-outline-dark d-inline-block mr-auto">Продолжить покупки</a>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('checkout.index') }}" class="btn btn-outline-success d-inline-block">Оформить заказ</a>
                        </div>
                    </div>
                @else
                    <div class="my-4">
                        <h3 class="mb-4">Ваша корзина пуста!</h3>
                        <a href="{{ route('guest.home') }}" class="btn btn-outline-dark">Продолжить покупки</a>
                    </div>
                @endif
            </div>
        </div>
  	</div>
    <div class="bg-light">
        <div class="container py-4">
            <h3 class="mb-4">Вас может заинтересовать:</h3>
            <div class="row">
                @include('components.product', ['products'=>$mightAlsoLike])
            </div>
        </div>
    </div>
    <script>
        (function(){
            let token = document.head.querySelector('meta[name="csrf-token"]');

            if (token) {
                // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
            } else {
                console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
            }

            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    const productQuantity = element.getAttribute('data-productQuantity')

                    $.ajax({
                        url: '/cart/' + id,
                        method: 'post',
                        data: {
                            quantity: this.value,
                            productQuantity: productQuantity,
                            '_method': 'PATCH'
                        },
                        complete: function () {
                            window.location.href = '{{ route('cart.index') }}'
                        }
                    });
                })
            })
        })();
    </script>
@endsection
