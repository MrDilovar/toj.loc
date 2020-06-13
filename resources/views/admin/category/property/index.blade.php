@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h3 class="font-weight-normal"><a class="text-dark" href="{{ route('admin.categories.properties.index', $category->id) }}">Атрибуты категории " {{ $category->name }} "</a></h3>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.index') }}">Назад</a>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.properties.create', $category->id) }}">Добавить</a>
            </div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Имя</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($category->properties as $property)
                <tr>
                    <th scope="row">{{ $property->id }}</th>
                    <td>{{ $property->name }}</td>
                    <td>
                        <form style="display: inline-block;" action="{{ route('admin.categories.properties.destroy', $category->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete" />
                            <input type="hidden" name="property_id" value="{{ $property->id }}" />
                            <button class="btn btn-sm btn-outline-dark" type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
