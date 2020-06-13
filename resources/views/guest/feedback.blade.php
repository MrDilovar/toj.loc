@extends('layout')
@section('content')
<div class="container">
	<h3 class="text-center my-4">Обратная связь</h3>
	<hr>
	@if(session()->get('success'))
		<div class="alert alert-success">
			{{ session()->get('success') }}
		</div><br />
	@elseif ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form class="formsValidate" method="post" action="{{ route('feedback.store') }}" novalidate>
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-6 my-2 border-right">
				<p class="text-center">ТИП ОБРАЩЕНИЯ</p>
				<div class="form-group">
					<div class="form-row">
						<div class="col">
							<select name="appeal" class="custom-select">
								@foreach ($appeals as $appeal)
									<option value="{{$loop->index}}" {{old('appeal') == $loop->index ? 'selected' : ''}}>{{ $appeal }}</option>
								@endforeach
						  	</select>
						</div>
						<div class="col">
							<select name="categoryAppeal" class="custom-select">
								@foreach ($categoryAppeals as $categoryAppeal)
									<option value="{{$loop->index}}" {{old('categoryAppeal') == $loop->index ? 'selected' : ''}}>{{ $categoryAppeal }}</option>
								@endforeach
				      		</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<input name="contactName" type="text" class="form-control w-75" value="{{ old('contactName') }}" placeholder="Ваше имя" required>
					@if ($errors->has('contactName'))
						<span class="font-weight-bold small">{{ $errors->first('contactName') }}</span>
					@endif
				</div>
				<div class="form-group">
					<input name="contactPhone" type="text" class="form-control w-75" value="{{ old('contactPhone') }}" placeholder="Телефон для связи">
					@if ($errors->has('contactPhone'))
						<span class="font-weight-bold small">{{ $errors->first('contactPhone') }}</span>
					@endif
				</div>
				<div class="form-group">
					<input name="contactEmail" type="email" class="form-control w-75" value="{{ old('contactEmail') }}" placeholder="Email">
					@if ($errors->has('contactEmail'))
						<span class="font-weight-bold small">{{ $errors->first('contactEmail') }}</span>
					@endif
				</div>
			</div>
			<div class="col-md-6 my-2">
				<p class="text-center">ОБРАЩЕНИЕ</p>
				<div class="form-group">
					<textarea name="contactReview" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ваш отзыв" required>{{ old('contactReview') }}</textarea>
					@if ($errors->has('contactReview'))
						<span class="font-weight-bold small">{{ $errors->first('contactReview') }}</span>
					@endif
				</div>
			</div>
			<div class="col-md-6 my-2">
				<div class="custom-control custom-checkbox mb-3">
				  	<input name="contactAgree" class="custom-control-input" type="checkbox" id="gridCheck" {{ old('contactAgree') === 'on' ? 'checked' : '' }} required>
				  	<label class="custom-control-label text-muted small" for="gridCheck">
						Я ознакомлен с содержанием пользовательского соглашения и принимаю условия обработки персональных данных.
				  	</label>
				</div>
				<div class="form-group">
			  		<button class="btn btn-primary" type="submit">Отправить</button>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection