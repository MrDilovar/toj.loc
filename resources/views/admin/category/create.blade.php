@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Каталог</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <form action="{{ route('admin.categories.store', ['parent_id'=>request()->parent_id]) }}" method="post">
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Название категории</div>
                    <div class="col-7 col-lg-4">
                        <input class="form-control form-control-sm" name="name" value="{{ old('name') }}" type="text">
                        @if ($errors->has('name'))
                            <span class="font-weight-bold small">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Добавить</button>
        </form>
    </div>
@endsection
