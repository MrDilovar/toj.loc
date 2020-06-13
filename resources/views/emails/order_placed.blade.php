@component('mail::message')
<h1 style="text-align:center">Заказ: #{{ $order->id }}</h1>

@component('mail::panel')
    ## Заказчик:
    Контактное лицо: {{ $order->customer->name }}
    Номер телефона: {{ $order->customer->phone }}
    Комментарии к заказу: {{ $order->customer->comment }}
@endcomponent

@component('mail::table')
| Название товара | Кол-во        | Цена     |
| -------------   |:-------------:| --------:|
@foreach($order->products as $product)
| {{ $product->name }} | {{ $product->pivot->quantity }} | {{ $product->price }} сом. |
@endforeach
|Итог:||{{ $order->total }} сом.|
@endcomponent

@component('mail::button', ['url' => route('store.order.show', $order->id), 'color' => 'blue'])
    Перейти в заказ
@endcomponent

С уважением,<br>{{ config('app.name') }}
@endcomponent
