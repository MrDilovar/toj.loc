@extends('store.layout')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Создать продукт</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('store.product.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <form class="" action="{{ route('store.product.store') }}" method="post"  enctype="multipart/form-data" novalidate>
                    {{ csrf_field() }}
                    @if(is_null($category))
                        <div class="form-group">
                            <label>Категория:</label>
                            <div class="border px-3 py-2">
                                <div class="pcat-menu" data-menu-id="0">
                                    <div class="mb-1">Все категории</div>
                                    @foreach($categories->getIndexCategories() as $category_item)
                                        <div class="mb-1">
                                            @if($category_item->children->isEmpty())
                                                <div class="custom-control custom-checkbox">
                                                    <input name="category_id" type="radio" value="{{ $category_item->id }}" class="custom-control-input" id="customCheck{{ $category_item->id }}" required>
                                                    <label class="custom-control-label" for="customCheck{{ $category_item->id }}">{{ $category_item->name }}</label>
                                                </div>
                                            @else
                                                <button type="button" class="btn btn-sm pcat-next-menu" data-next-menu-id="{{ $category_item->id }}" data-menu-id="0">
                                                    <span>{{ $category_item->name }}</span>
                                                    <span class="oi oi-arrow-right"></span>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                @foreach($categories->all() as $category_item)
                                    @if(!$category_item->children->isEmpty())
                                        <div class="pcat-menu" data-menu-id="{{ $category_item->id }}" style="display: none">
                                            <div class="mb-1">
                                                <button type="button" class="btn btn-sm pcat-prev-menu" data-menu-id="{{ $category_item->id }}" data-prev-menu-id="{{ $category_item->parent ? $category_item->parent->id : 0 }}">
                                                    <span class="oi oi-arrow-left"></span>
                                                    <span>{{ $category_item->name }}</span>
                                                </button>
                                            </div>
                                            @foreach($category_item->children as $children)
                                                <div class="mb-1">
                                                    @if($children->children->isEmpty())
                                                        <div class="custom-control custom-checkbox">
                                                            <input name="category_id" type="radio" value="{{ $children->id }}" class="custom-control-input" id="customCheck{{ $children->id }}" required>
                                                            <label class="custom-control-label" for="customCheck{{ $children->id }}">{{ $children->name }}</label>
                                                        </div>
                                                    @else
                                                        <button type="button" class="btn btn-sm pcat-next-menu" data-menu-id="{{ $category_item->id }}" data-next-menu-id="{{ $children->id }}">
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
                    @else
                        <h4>Категория: {{ $category->name }}</h4>
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <div class="form-group">
                            <label for="inputName">Имя:</label>
                            <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-sm" id="inputName" required>
                            @if ($errors->has('name'))
                                <span class="font-weight-bold small">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPrice">Цена: <strong>в сомони</strong></label>
                            <input name="price" value="{{ old('price') }}" type="text" class="form-control form-control-sm" id="inputPrice" required>
                            @if ($errors->has('price'))
                                <span class="font-weight-bold small">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Описание:</label>
                            <textarea name="description" class="form-control form-control-sm" id="inputDescription" required>{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="font-weight-bold small">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputImage">Картинка:</label>
                            <input name="image" class="w-100 form-control h-100" id="inputImage" type="file" required>
                            <small class="form-text text-muted">Пожалуйста, загрузите действительный файл изображения. Размер изображения не должен превышать 10 МБ.</small>
                        </div>
                        @foreach($category->attributes as $attribute)
                            <div class="form-group">
                                <label for="inputName1">{{ $attribute->name }}:</label>
                                <select name="attr[{{ $attribute->id }}]">
                                    <option>Выберите значение</option>
                                    @foreach($attribute->values as $value)
                                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    @endif
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

            $('input[name="category_id"]').change(function (e) {
                let category_id = e.target.value;
                location.search = "category_id=" + category_id;
            });
        }
    </script>
@endsection
