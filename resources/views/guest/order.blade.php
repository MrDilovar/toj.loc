@extends('layout')
@section('content')
    <div class="container py-4" style="min-height: 450px;">
        <div class="row mb-4">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="mb-3 font-weight-light text-center">Заказ: <span class="font-weight-bold">#{{ $customer->id }}</span></h4>
                @foreach($customer->orders as $order)
                    <div class="mb-3">
                        <div class="row mx-0 py-2">
                            <div class="col">Магазн</div>
                            <div class="col-auto"><span class="font-weight-bold">{{ $order->user->store->name }}</span></div>
                        </div>
                        <div class="row border-top mx-0 py-2">
                            <div class="col">Номер заказа</div>
                            <div class="col-auto"><span class="font-weight-bold">#{{ $order->id }}</span></div>
                        </div>
                        @foreach($order->products as $product)
                            <div class="row border-top mx-0 py-2">
                                <div class="col"><a class="text-dark" href={{ route('guest.product', $product->id) }}>{{ $product->name }}</a></div>
                                <div class="col-auto">{{ $product->pivot->quantity }} шт.</div>
                                <div class="col-auto">{{ $product->price }} сом.</div>
                            </div>
                        @endforeach
                        <div class="row border-top mx-0 py-2">
                            <div class="col"><span class="font-weight-bold">Итог:</span></div>
                            <div class="col-auto"><span class="font-weight-bold">{{ $order->total }} сом.</span></div>
                        </div>
                    </div>
                @endforeach
                <div class="text-center">
                    <a href="{{ route('guest.home') }}" class="btn btn-outline-dark">Главная страница</a>
                </div>
            </div>
        </div>
    </div>
@endsection
