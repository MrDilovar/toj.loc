@extends('store.layout')

@section('content')
	<div class="container my-4">
		<div class="row">
			<div class="col-sm-3"><h3><a class="text-dark" href="{{ route('store.order.index') }}">Заказы</a></h3></div>
            <div class="col-sm-auto ml-auto mt-4 mt-sm-0">
                <form action="{{ route('store.order.index') }}" method="get">
                    <div class="row no-gutters">
                        <div class="col mr-3">
                            <input class="form-control form-control-sm" name="search" type="text" value="{{ request()->search }}" placeholder="ID заказа">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-primary"><span class="oi oi-magnifying-glass"></span></button>
                        </div>
                    </div>
                </form>
            </div>
		</div>
		<div class="mt-4">
		  @if(session()->get('success'))
		    <div class="alert alert-success">
		      {{ session()->get('success') }}
		    </div>
		  @endif
          @if(request()->has('search') && !is_null(request()->search))
              <div class="mb-4">
                  <h5 class="font-weight-normal">Результаты поиска: " {{ request()->search }} "</h5>
              </div>
          @endif
		  <table class="table">
		  	<thead class="thead-light">
			    <tr>
			      	<th scope="col">ID</th>
					<th scope="col">Имя</th>
					<th scope="col">Телефон</th>
					<th scope="col">Статус</th>
					<th scope="col">Дата</th>
			    </tr>
			  </thead>
		    <tbody>
                @forelse($orders as $order)
                    <tr class="{{ $loop->index % 2 != 0 ? 'bg-light' : '' }}">
                        <th scope="row">{{ $order->id }}</th>
                        <td><a class="text-dark" style="text-decoration: underline" href={{ route('store.order.show', $order->id) }}>{{ $order->customer->name }}</a></td>
                        <td>{{ $order->customer->phone }}</td>
                        <td>
                            <select class="form-control form-control-sm orderStatus {{ $order->status->id == 1 ? 'bg-light' : ($order->status->id == 2 ? 'bg-primary text-white' : ($order->status->id == 3 ? 'bg-success text-white' : 'bg-danger text-white')) }}" data-id="{{ $order->id }}">
                                @foreach($statuses as $status)
                                    <option {{ $status->id == $order->status->id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>{{ $order->data }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>Сожалеем, но ничего не найдено.</td>
                    </tr>
                @endforelse
		    </tbody>
		  </table>
		</div>
	</div>
@endsection
