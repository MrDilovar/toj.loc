@extends('store.layout')

@section('content')
<div class="container py-4">
	<div class="row mb-4">
		<div class="col-lg-8 offset-lg-2">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <h3 class="mb-3">Заказ: #{{ $order->id }}</h3>
                </div>
                <div class="col-auto">
                    <a href="{{ route('store.order.index') }}" class="btn btn-light border">Назад</a>
                </div>
            </div>
			<h4 class="my-3 font-weight-light">Заказчик</h4>
			<div class="row mx-0 py-2">
				<div class="col-6">Фамилия и имя</div>
				<div class="col-auto"><h6>{{ $order->customer->name }}</h6></div>
			</div>
			<div class="row border-top mx-0 py-2">
				<div class="col-6">Телефон</div>
				<div class="col-auto"><h6>{{ $order->customer->phone }}</h6></div>
			</div>
			<div class="row border-top mx-0 py-2">
				<div class="col-6">Комментарии к заказу</div>
				<div class="col-auto"><h6>{{ $order->customer->comment }}</h6></div>
			</div>
			<div class="row border-top mx-0 py-2">
				<div class="col"><h5>Дата:</h5></div>
				<div class="col-auto"><h6>{{ $order->data }}</h6></div>
			</div>
            <div class="row align-items-center">
                <div class="col-auto">
                    <h4 class="my-3 font-weight-light">Заказ</h4>
                </div>
                <div class="col-auto">
                    <select class="form-control form-control-sm orderStatus {{ $order->status->id == 1 ? 'bg-light' : ($order->status->id == 2 ? 'bg-primary text-white' : ($order->status->id == 3 ? 'bg-success text-white' : 'bg-danger text-white')) }}" data-id="{{ $order->id }}">
                        @foreach($statuses as $status)
                            <option {{ $status->id == $order->status->id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
			@foreach($order->products as $product)
				<div class="row border-bottom mx-0 py-2">
					<div class="col"><a class="text-dark" href={{ route('guest.product', $product->id) }}>{{ $product->name }}</a></div>
					<div class="col-auto">{{ $product->pivot->quantity }} шт.</div>
					<div class="col-auto"><h6>{{ $product->price }} сом.</h6></div>
				</div>
			@endforeach
			<div class="row mx-0 py-2">
				<div class="col"><h5>Итог:</h5></div>
				<div class="col-auto"><h5>{{ $order->total }} сом.</h5></div>
			</div>
		</div>
	</div>
</div>
@endsection
