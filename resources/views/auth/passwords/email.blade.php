@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 col-sm-9 col-md-7 col-lg-5 mx-auto">
            <h2 class="text-center mt-5 mb-3">Восстановление пароля</h2>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="col-form-label">Электронный адрес</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary btn-block">
                        Отправить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
