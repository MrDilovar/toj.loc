@extends('admin.layout')

@section('content')
	<div class="container py-4">
		<div class="row mb-4">
			<div class="col-lg-10 offset-lg-1">
				<h3 class="mb-3 font-weight-light text-center">Отзыв <span class="font-weight-bold">#{{ $feedback->id }}</span></h3>
				<table class="table table-striped mt-4">
					<tr>
						<th scope="row">Обращения</th>
				  <td>{{ $feedback->appeal }}</td>
					</tr>
					<tr>
						<th scope="row">Тип обращения</th>
				  <td>{{ $feedback->categoryAppeal }}</td>
					</tr>
					<tr>
						<th scope="row">Имя</th>
				  <td>{{ $feedback->contactName }}</td>
					</tr>
					<tr>
						<th scope="row">Телефон</th>
				  <td>{{ $feedback->contactPhone }}</td>
					</tr>
					<tr>
						<th scope="row">Почта</th>
				  <td>{{ $feedback->contactEmail }}</td>
					</tr>
					<tr>
						<th scope="row">Отзыв</th>
				  <td>{{ $feedback->contactReview }}</td>
					</tr>
					<tr>
						<th scope="row">Время отправления</th>
				  <td>{{ $feedback->data }}</td>
					</tr>
				</table>
				<form action="{{ route('admin.feedback.destroy', $feedback->id)}}" method="post" class="text-center mt-4">
	    {{ csrf_field() }}
	    <input type="hidden" name="_method" value="delete" />
	    <button class="btn btn-danger w-25" type="submit">Удалить</button>
	  </form>
			</div>
		</div>
	</div>
@endsection