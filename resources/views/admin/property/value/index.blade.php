@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h3 class="font-weight-normal"><a class="text-dark" href="{{ route('admin.properties.property_values.index', $property->id) }}">Значений атрибута " {{ $property->name }} "</a></h3>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.properties.index') }}">Назад</a>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.properties.property_values.create', $property->id) }}">Создать</a>
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
            @foreach($property->values as $value)
                <tr>
                    <th scope="row">{{ $value->id }}</th>
                    <td>{{ $value->value }}</td>
                    <td>
                        <a href="{{ route('admin.property_values.edit', $value->id) }}" class="btn btn-sm btn-outline-dark">Изменить</a>
                        <form style="display: inline-block;" action="{{ route('admin.property_values.destroy', $value->id) }}" method="post">
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
