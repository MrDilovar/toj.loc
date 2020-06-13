@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Редактировать значения атрибута</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.properties.property_values.index', $value->property->id) }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form class="formsValidate" action="{{ route('admin.property_values.update', $value->id) }}" method="post" novalidate>
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="inputValue">Значение</label>
                    </div>
                    <div class="col-7 col-lg-4">
                        <input name="value" value="{{ old('value') ? old('value') : $value->value }}" type="text" class="form-control form-control-sm" id="inputValue" required>
                        @if ($errors->has('value'))
                            <span class="text-danger small">{{ $errors->first('value') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Редактировать</button>
        </form>
    </div>
@endsection
