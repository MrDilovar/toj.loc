@extends('store.layout')

@section('content')
	<div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h3 class="font-weight-normal"><a class="text-dark" href="{{ route('store.product.index') }}">Продукты</a></h3>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('store.product.create') }}">Создать</a>
            </div>
            <div class="col-sm-auto ml-auto mt-4 mt-sm-0">
                <form action="{{ route('store.product.index') }}" method="get">
                    <div class="row no-gutters">
                        <div class="col mr-3">
                            <input class="form-control form-control-sm" name="search" type="text" value="{{ request()->search }}" placeholder="Название товара">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-primary"><span class="oi oi-magnifying-glass"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(request()->has('search') && !is_null(request()->search))
            <div class="mb-4">
                <h5 class="font-weight-normal">Результаты поиска: " {{ request()->search }} "</h5>
            </div>
        @endif
        <div class="row mb-3">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 text-center">
                        <div class="p-3">
                            <a href="{{ route('guest.product', $product->id) }}"><img style="max-width: 150px; max-height: 150px;" src="{{ $product->full_path_to_image() }}" alt=""></a>
                        </div>
                        <div class="mx-2">
                            <h6 class="card-title"><a class="text-dark" href="{{ route('guest.product', $product->id) }}">{{ $product->name }}</a></h6>
                            <h6 class="font-weight-light">{{ $product->price }} сом.</h6>
                        </div>
                        <div class="mt-auto mb-3">
                            <hr class="w-75">
                            <a href="{{ route('store.product.edit', $product->id) }}" class="btn btn-sm btn-outline-dark">Изменить</a>
                            <form class="d-inline confirmAction" action="{{ route('store.product.destroy', $product->id) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete" />
                                <button class="btn btn-sm btn-outline-dark" type="submit">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">Сожалеем, но ничего не найдено.</div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $products->appends(request()->input())->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
