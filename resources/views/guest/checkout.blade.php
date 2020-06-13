@extends('layout')
@section('content')
    <div class="container py-4">
        <h3 class="mb-3">Оформление заказа</h3>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h5 class="mb-3">Ваш заказ</h5>
                @foreach (Cart::content() as $product)
                    <div class="row border-top mx-0 py-2">
                        <div class="col"><a class="text-dark" href="{{ route('guest.product', $product->model->id) }}">{{ $product->model->name }}</a></div>
                        <div class="col-auto">{{ $product->qty }} шт.</div>
                        <div class="col-auto"><span class="font-weight-bold">{{ $product->subtotal }} сом.</span></div>
                    </div>
                @endforeach
                <div class="row border-top mx-0 py-2">
                    <div class="col"><h5>Итог:</h5></div>
                    <div class="col-auto"><h5>{{ Cart::subtotal() }} сом.</h5></div>
                </div>
            </div>
            <div class="col-lg-6">
                <h5 class="mb-3">Ваши данные</h5>
                <form class="formsValidate" action="{{ route('checkout.store') }}" method="POST" novalidate>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="inputName">Фамилия и имя *</label>
                        <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-sm" id="inputName" required>
                        @if ($errors->has('name'))
                            <span class="font-weight-bold small">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Телефон *</label>
                        <input name="phone" value="{{ old('phone') }}" type="text" class="form-control form-control-sm" id="inputPhone" required>
                        @if ($errors->has('phone'))
                            <span class="font-weight-bold small">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputComment">Комментарии к заказу</label>
                        <textarea name="comment" value="{{ old('comment') }}" class="form-control form-control-sm" id="inputComment"></textarea>
                    </div>
                    <div class="form-group custom-control custom-checkbox">
                        <input name="contactAgree" type="checkbox" class="custom-control-input" id="contactAgree" {{ old('contactAgree') === 'on' ? 'checked' : '' }} required>
                        <label class="custom-control-label" for="contactAgree">Я ознакомлен с содержанием пользовательского соглашения и принимаю условия обработки персональных данных.</label>
                        @if ($errors->has('contactAgree'))
                            <span class="font-weight-bold small">{{ $errors->first('contactAgree') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Оформить заказ</button>
                </form>
            </div>
        </div>
    </div>
@endsection
