@extends('store.layout')

@section('content')
    <div class="container py-3">
        <h4 class="mt-2">Store</h4>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <hr>
        <h5 class="mb-4 font-weight-normal">Основные данные</h5>
        <form action="{{ route('store.profile.update') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-lg-2">Имя компании</div>
                <div class="col-7 col-lg-4">
                    <input name="name" type="text" class="form-control form-control-sm" value="{{ $user->store->name }}">
                    @if ($errors->has('name'))
                        <span class="font-weight-bold small">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Телефон</div>
                <div class="col-7 col-lg-4">
                    <input name="phone" type="text" class="form-control form-control-sm" value="{{ $user->store->phone }}">
                    @if ($errors->has('phone'))
                        <span class="font-weight-bold small">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Адрес компании</div>
                <div class="col-7 col-lg-4">
                    <input name="address" type="text" class="form-control form-control-sm" value="{{ $user->store->address }}">
                    @if ($errors->has('address'))
                        <span class="font-weight-bold small">{{ $errors->first('address') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">О компании</div>
                <div class="col-7 col-lg-4">
                    <textarea name="description" type="text" class="form-control form-control-sm">{{ $user->store->description }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary mb-3 shadow">Изменить</button>
        </form>
        <hr>
        <h5 class="mb-3 font-weight-normal">Логотип компании</h5>
        <div class="row">
            <div class="col-sm-6">
                <form class="border my-3 rounded" action="{{ route('store.profile.logo.update') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="p-3 text-center">
                        @if(is_null($user->store->logo))
                            <div class="text-muted">Не задано...</div>
                        @else
                            <img src="{{$user->store->full_path_to_logo() }}" class="img-fluid" style="max-width: 150px; max-height: 150px;" alt="store logo...">
                        @endif
                    </div>
                    <div class="bg-light p-3">
                        <div class="form-group">
                            <input class="w-100" name="logo" type="file">
                            @if ($errors->has('logo'))
                                <span class="font-weight-bold small">{{ $errors->first('logo') }}</span>
                                <br>
                            @endif
                            <small class="form-text text-muted">Пожалуйста, загрузите действительный файл изображения. Размер изображения не должен превышать 10 МБ.</small>
                        </div>
                        <button class="btn btn-sm btn-primary shadow" type="submit">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <h5 class="mb-3 font-weight-normal">Параметры входа</h5>
        <div class="form-group row">
            <div class="col-lg-2">E-Mail Address</div>
            <div class="col-7 col-lg-4">
                <input type="text" class="form-control form-control-sm" value={{ $user->email }} disabled>
                @if ($errors->has('email'))
                    <span class="font-weight-bold small">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm shadow" data-toggle="modal" data-target="#emailEditModal">Изменить</button>
                <div class="modal fade" id="emailEditModal" tabindex="-1" role="dialog" aria-labelledby="emailEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form class="formsValidate" action="{{ route('email.email') }}" method="post" novalidate>
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title">Изменить</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-4">Email address</div>
                                            <div class="col-sm-8">
                                                <input name="email" type="email" class="form-control form-control-sm" value={{ $user->email }} required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Отменить</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">Текущий пароль</div>
            <div class="col-7 col-lg-4">
                <input type="password" class="form-control form-control-sm" placeholder="******" disabled>
                @if ($errors->has('password'))
                    <span class="font-weight-bold small">{{ $errors->first('password') }}</span>
                @endif
                @if ($errors->has('new_password'))
                    <span class="font-weight-bold small">{{ $errors->first('new_password') }}</span>
                @endif
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm shadow" data-toggle="modal" data-target="#passwordEditModal">Изменить</button>
                <div class="modal fade" id="passwordEditModal" tabindex="-1" role="dialog" aria-labelledby="passwordEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form class="formsValidate" action="{{ route('store.profile.password.update') }}" method="post" novalidate>
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title">Изменить</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="form-group row">
                                            <div class="col-sm-4">Текущий пароль</div>
                                            <div class="col-sm-8">
                                                <input name="password" type="password" class="form-control form-control-sm" placeholder="******" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">Новый пароль</div>
                                            <div class="col-sm-8">
                                                <input name="new_password" type="password" class="form-control form-control-sm" placeholder="******" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">Подтверждение пароля</div>
                                            <div class="col-sm-8">
                                                <input name="new_password_confirmation" type="password" class="form-control form-control-sm" placeholder="******" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Отменить</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
