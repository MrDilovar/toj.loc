@extends('admin.layout')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-6 col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Каталог</h5>
                    <p class="card-text">Количество: {{ $categories->count() }}</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Посмотреть</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Атрибуты</h5>
                    <p class="card-text">Количество: {{ $attributes->count() }}</p>
                    <a href="{{ route('admin.properties.index') }}" class="btn btn-primary">Посмотреть</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Отзывы</h5>
                    <p class="card-text">Количество: {{ $feedbacks->count() }}</p>
                    <a href="{{ route('admin.feedback.index') }}" class="btn btn-primary">Посмотреть</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
