@extends('store.layout')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-6 col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Продукты</h5>
                    <p class="card-text">Количество: {{ $products->count() }}</p>
                    <a href="{{ route('store.product.index') }}" class="btn btn-primary">Посмотреть</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Заказы</h5>
                    <p class="card-text">Количество: {{ $orders->count() }}</p>
                    <a href="{{ route('store.order.index') }}" class="btn btn-primary">Посмотреть</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
