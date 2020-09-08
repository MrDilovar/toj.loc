@forelse ($products as $product)
    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="product-item">
            <div class="pi-pic">
                <a href="{{ route('guest.product', $product->id) }}">
                    <img src="{{ $product->image_medium }}" alt="">
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
        </div>
    </div>
@empty
    <div class="col">Сожалеем, но ничего не найдено.</div>
@endforelse
