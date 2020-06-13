@extends('layout')
@section('content')
    <div class="container py-4">
        <h3 class="products-title-a text-center my-4">Новые поступления</h3>
        <div class="row">
            @include('components.product')
        </div>
    </div>
@endsection
