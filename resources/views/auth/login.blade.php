@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 col-sm-8 col-md-6 col-lg-4 mx-auto">
            <h2 class="text-center mt-5 mb-3">Вход</h2>

            <form method="POST" action="{{ route('login') }}">
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
                    <label for="password" class="col-form-label">Пароль</label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="custom-control-label" for="remember">Запомнить меня</label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Войти</button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Забыли пароль?
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
