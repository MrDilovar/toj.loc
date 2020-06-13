@extends('admin.layout')

@section('content')
	<div class="container my-4">
		<div class="row">
			<div class="col-sm-3"><h3>Отзывы</h3></div>
		</div>
		<div class="mt-4">
		  @if(session()->get('success'))
		    <div class="alert alert-success">
		      {{ session()->get('success') }}  
		    </div>
		  @endif
		  <table class="table">
		  	<thead class="thead-light">
			    <tr>
			      <th scope="col">ID</th>
			      <th scope="col">Обращения</th>
			      <th scope="col">Тип обращения</th>
			      <th scope="col">Дата обращения</th>
			      <th scope="col">Отзыв</th>
			      <th scope="col">Действие</th>
			    </tr>
			  </thead>
		    <tbody>
		        @foreach($feedbacks as $feedback)
		        <tr>
		            <th scope="row">{{ $feedback->id }}</th>
		            <td>{{ $feedback->appeal }}</td>
		            <td>{{ $feedback->categoryAppeal }}</td>
		            <td>{{ $feedback->data }}</td>
		            <td>{{ $feedback->contactReview }}</td>
		            <td>
		            	<a href="{{ route('admin.feedback.show', $feedback->id)}}" class="btn btn-primary">Посмотреть</a>
		            	<form style="display: inline-block;" action="{{ route('admin.feedback.destroy', $feedback->id)}}" method="post">
	                  {{ csrf_field() }}
	                  <input type="hidden" name="_method" value="delete" />
	                  <button class="btn btn-danger" type="submit">Удалить</button>
	                </form>
		            </td>
		        </tr>
		        @endforeach
		    </tbody>
		  </table>
		</div>
	</div>
@endsection