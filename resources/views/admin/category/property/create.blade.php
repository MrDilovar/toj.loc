@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Добавить атрибут в категории</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.categories.properties.index', $category->id) }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Имя</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($category->nonExistentProperties() as $property)
                <tr>
                    <th scope="row">{{ $property->id }}</th>
                    <td>{{ $property->name }}</td>
                    <td>
                        <form style="display: inline-block;" action="{{ route('admin.categories.properties.store', $category->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="property_id" value="{{ $property->id }}" />
                            <button class="btn btn-sm btn-outline-dark" type="submit">Добавить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
