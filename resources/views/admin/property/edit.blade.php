@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Редактировать атрибут</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form class="formsValidate" action="{{ route('admin.properties.update', $property->id) }}" method="post" novalidate>
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="inputName">Имя</label>
                    </div>
                    <div class="col-7 col-lg-4">
                        <input name="name" value="{{ old('name') ? old('name') : $property->name }}" type="text" class="form-control form-control-sm" id="inputName" required>
                        @if ($errors->has('name'))
                            <span class="text-danger small">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="inputDescription">Описания</label>
                    </div>
                    <div class="col-7 col-lg-4">
                        <input name="description" value="{{ old('description') ? old('description') : $property->description }}" type="text" class="form-control form-control-sm" id="inputDescription">
                        @if ($errors->has('description'))
                            <span class="text-danger small">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Редактировать</button>
        </form>
    </div>
@endsection
