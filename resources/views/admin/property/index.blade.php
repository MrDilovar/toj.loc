@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h3 class="font-weight-normal"><a class="text-dark" href="{{ route('admin.properties.index') }}">Атрибуты</a></h3>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.properties.create') }}">Создать</a>
            </div>
            <div class="col-sm-auto ml-auto mt-4 mt-sm-0">
                <form action="{{ route('admin.properties.index') }}" method="get">
                    <div class="row no-gutters">
                        <div class="col mr-3">
                            <input class="form-control form-control-sm" name="search" type="text" value="{{ request()->search }}" placeholder="Имя атрибута">
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
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Имя</th>
                <th scope="col">Значений атрибута</th>
                <th scope="col">Описания</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($properties as $property)
                <tr>
                    <th scope="row">{{ $property->id }}</th>
                    <td>{{ $property->name }}</td>
                    <td>{{ $property->values->count() }} - <a href="{{ route('admin.properties.property_values.index', $property->id) }}">редактировать</a></td>
                    <td>{{ $property->description }}</td>
                    <td>
                        <a href="{{ route('admin.properties.edit', $property->id)}}" class="btn btn-sm btn-outline-dark">Изменить</a>
                        <form style="display: inline-block;" action="{{ route('admin.properties.destroy', $property->id)}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete" />
                            <button class="btn btn-sm btn-outline-dark" type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
