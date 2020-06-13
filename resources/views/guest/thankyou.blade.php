@extends('layout')
@section('content')
    <div class="container py-4" style="min-height: 450px;">
        <div class="row mb-4">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="mb-3 font-weight-light text-center">Ваш заказ: <span class="font-weight-bold">#{{ $order->id }}</span></h4>
                @foreach($order->products as $product)
                    <div class="row border-top mx-0 py-2">
                        <div class="col"><a class="text-dark" href={{ route('guest.product', $product->id) }}>{{ $product->name }}</a></div>
                        <div class="col-auto">{{ $product->pivot->quantity }} шт.</div>
                        <div class="col-auto"><span class="font-weight-bold">{{ $product->price }} сом.</span></div>
                    </div>
                @endforeach
                <div class="row border-top mx-0 py-2">
                    <div class="col"><h5>Итог:</h5></div>
                    <div class="col-auto"><h5>{{ $order->total }} сом.</h5></div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="{{ route('guest.home') }}" class="btn btn-outline-dark">Главная страница</a>
        </div>
    </div>
@endsection