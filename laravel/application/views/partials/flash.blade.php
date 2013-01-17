@section('flashes')
	<div class="alert alert-{{$status}}">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		{{$message}}
	</div>
@endsection