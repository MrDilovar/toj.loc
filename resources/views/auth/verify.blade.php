@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
        <h2 class="text-center mt-5 mb-4">Подтвердите ваш адрес электронной почты</h2>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.
                </div>
            @endif

            В целях безопасности вам нужно подтвердить свой email адрес. Если вы не получили письмо,
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">нажмите здесь</button>, чтобы получить ссылку для подтверждения еще раз.
            </form>
        </div>
    </div>
</div>
@endsection
