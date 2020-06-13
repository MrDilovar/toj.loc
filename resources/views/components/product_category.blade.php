@forelse ($products as $product)
    <div class="col-sm-6 col-lg-4 mb-4">
        <div class="product-item">
            <div class="pi-pic">
                <a href="{{ route('guest.product', $product->id) }}">
                    <img src="{{ $product->full_path_to_image() }}" alt="">
                </a>
            </div>
            <div class="product-title">
                <a href="{{ route('guest.product', $product->id) }}">
                    <h5>{{ $product->name }}</h5>
                </a>
            </div>
            <div class="product-price">
                {{ $product->price }}
                <span>сом.</span>
            </div>
            <div>
                @foreach(json_decode($product->options, true) as $option)
                    {{ $option['attr']['name'] }}: {{ $option['value']['value'] }}
                    <br>
                @endforeach
            </div>
        </div>
    </div>
@empty
    <div class="col">Сожалеем, но ничего не найдено.</div>
@endforelse