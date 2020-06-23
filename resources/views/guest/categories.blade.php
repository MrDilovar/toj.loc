@extends('layout')
@section('content')
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('guest.home') }}">Главная</a></li>
                @foreach($array_breadcrumb as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a class="text-dark" href="{{ route('guest.categories', $breadcrumb['href']) }}">{{ $breadcrumb['title'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-3">
                <div class="filter-widget">
                    <h5 class="fwc-title active">{{ $category->name }}</h5>
                    <ul class="filter-catagories ml-2">
                        @foreach($category->children as $child)
                            <li>
                                <a href="{{ route('guest.categories', $child->get_full_slug()) }}">{{ $child->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    @if($category->children->isEmpty())
                        <hr class="my-2">
                    @endif
                    <div class="filter-catagories">
                        @foreach($category->neighbors() as $neighbor)
                            @if($category->active($neighbor->id))
                                @continue
                            @else
                                <a class="fwc-title" href="{{ route('guest.categories', $neighbor->get_full_slug()) }}">{{ $neighbor->name }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div id="filterPanelLeft"
                     data-category-id="{{ $category->id }}"
                     data-filter-model="{{ $category->get_properties_with_values() }}"
                     data-open-filters="{{ $open_properties }}">
                </div>
            </div>
            <div class="col-md-9">
                <div class="row align-items-center mb-3">
                    <div class="col-auto mr-auto">
                        <h4>{{ $category->name }}</h4>
                    </div>
                    <div class="col-auto">
                        <div class="row no-gutters">
                            <div class="col-auto mr-2">
                                @if($sort === 'newly')
                                    <span class="text-success">Новые</span>
                                @else
                                    <a href="{{ route('guest.categories', ['slug'=> request()->slug, 'sort' => 'newly']) }}" class="text-dark">Новые</a>
                                @endif
                            </div>
                            <div class="col-auto mr-2">
                                @if($sort === 'priceup')
                                    <span class="text-success">Дешевые</span>
                                @else
                                    <a href="{{ route('guest.categories', ['slug'=> request()->slug, 'sort' => 'priceup']) }}" class="text-dark">Дешевые</a>
                                @endif
                            </div>
                            <div class="col-auto mr-2">
                                @if($sort === 'pricedown')
                                    <span class="text-success">Дорогие</span>
                                @else
                                    <a href="{{ route('guest.categories', ['slug'=> request()->slug, 'sort' => 'pricedown']) }}" class="text-dark">Дорогие</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @include('components.product_category')
                </div>
{{--                {{ $products->appends(request()->input())->links('pagination::bootstrap-4') }}--}}
            </div>
        </div>
    </div>
@endsection
