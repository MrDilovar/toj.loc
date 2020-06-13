@extends('store.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Редактировать продукт</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('store.product.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <form class="formsValidate" action="{{ route('store.product.update', $product->id) }}" method="post"  enctype="multipart/form-data" novalidate>
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Категория:</label>
                        <div class="border px-3 py-2">
                            <div class="pcat-menu" data-menu-id="0" style="{{ is_null($product->category->parent())  ? '' : 'display: none'}}">
                                <div class="mb-1">Все категории</div>
                                @foreach($categories->getIndexCategories() as $category)
                                    <div class="mb-1">
                                        @if($category->children()->isEmpty())
                                            <div class="custom-control custom-checkbox">
                                                <input name="category_id" type="radio" value="{{ $category->id }}" {{ $product->category->id == $category->id ? 'checked' : '' }} class="custom-control-input" id="customCheck{{ $category->id }}" required>
                                                <label class="custom-control-label" for="customCheck{{ $category->id }}">{{ $category->name }}</label>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-sm pcat-next-menu" data-next-menu-id="{{ $category->id }}" data-menu-id="0">
                                                <span>{{ $category->name }}</span>
                                                <span class="oi oi-arrow-right"></span>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @foreach($categories->all() as $category)
                                @if(!$category->children()->isEmpty())
                                    <div class="pcat-menu" data-menu-id="{{ $category->id }}" style="{{ is_null($product->category->parent()) ? 'display: none' : ($product->category->parent()->id == $category->id ? '' : 'display: none')}}">
                                        <div class="mb-1">
                                            <button type="button" class="btn btn-sm pcat-prev-menu" data-menu-id="{{ $category->id }}" data-prev-menu-id="{{ $category->parent() ? $category->parent()->id : 0 }}">
                                                <span class="oi oi-arrow-left"></span>
                                                <span>{{ $category->name }}</span>
                                            </button>
                                        </div>
                                        @foreach($category->children() as $children)
                                            <div class="mb-1">
                                                @if($children->children()->isEmpty())
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="category_id" type="radio" value="{{ $children->id }}" {{ $product->category->id == $children->id ? 'checked' : '' }} class="custom-control-input" id="customCheck{{ $children->id }}" required>
                                                        <label class="custom-control-label" for="customCheck{{ $children->id }}">{{ $children->name }}</label>
                                                    </div>
                                                @else
                                                    <button type="button" class="btn btn-sm pcat-next-menu" data-menu-id="{{ $category->id }}" data-next-menu-id="{{ $children->id }}">
                                                        <span>{{ $children->name }}</span>
                                                        <span class="oi oi-arrow-right"></span>
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <input class="form-control d-none" name="category_id" type="radio" required>
                        <div class="invalid-feedback font-weight-bold">Выберите категорию</div>
                        @if ($errors->has('category_id'))
                        <span class="font-weight-bold small">{{ $errors->first('category_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputName">Имя:</label>
                        <input name="name" value="{{ old('name') ? old('name') : $product->name }}" type="text" class="form-control form-control-sm" id="inputName" required>
                        @if ($errors->has('name'))
                          <span class="font-weight-bold small">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputPrice">Цена: <strong>в сомони</strong></label>
                        <input name="price" value="{{ old('price') ? old('price') : $product->price }}" type="text" class="form-control form-control-sm" id="inputPrice" required>
                        @if ($errors->has('price'))
                          <span class="font-weight-bold small">{{ $errors->first('price') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Описание:</label>
                        <textarea name="description" class="form-control form-control-sm" id="inputDescription" required>{{ old('description') ? old('description') : $product->description }}</textarea>
                        @if ($errors->has('description'))
                            <span class="font-weight-bold small">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                    <label for="inputImage">Картинка:</label>
                    <div class="mb-3">
                      <img style="max-height: 250px;" src="{{ $product->full_path_to_image() }}" alt="...">
                    </div>
                    <input name="image" class="w-100 form-control h-100" id="inputImage" type="file">
                    <small class="form-text text-muted">Пожалуйста, загрузите действительный файл изображения. Размер изображения не должен превышать 10 МБ.</small>
                  </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Редактировать</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.onload = function () {
            $('.pcat-next-menu').click(function (e) {
                let self = $(this);
                $(".pcat-menu[data-menu-id=" + self.data().menuId + "]").fadeOut(0),
                    $(".pcat-menu[data-menu-id=" + self.data().nextMenuId + "]").fadeIn();
            });

            $('.pcat-prev-menu').click(function (e) {
                let self = $(this);
                $(".pcat-menu[data-menu-id=" + self.data().menuId + "]").fadeOut(0);
                $(".pcat-menu[data-menu-id=" + self.data().prevMenuId + "]").fadeIn();
            });
        }
    </script>
@endsection
