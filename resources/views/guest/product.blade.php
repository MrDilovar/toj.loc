@extends('layout')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 p-3 text-center">
                <img style="max-height: 200px; max-width: 100%;" src="{{ $product->image_medium }}" alt="...">
            </div>
            <div class="col-sm-6 col-md-8 col-lg-9">
                <h3>{{ $product->name }}</h3>
                <h3 class="font-weight-light">{{ $product->price }} сом.</h3>
                <form action="{{ route('cart.store', $product->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-outline-dark my-3">В корзину</button>
                </form>
            </div>
        </div>
        <div>
            <hr>
            <h3>Описание</h3>
            <p>{!! $product->description !!}</p>
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
@endsection
