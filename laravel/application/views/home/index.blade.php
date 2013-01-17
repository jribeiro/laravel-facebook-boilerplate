@layout('layouts.default')

@include('partials.topmenu')

@section('flashes')
	{{ HTML::flash() }}
@endsection

@section('content')
	{{ Form::search_open() }}
 	<center>
 		{{ Form::search_box('search',null, array('class' => 'center input-xxlarge')) }}
 	<center>
	<!--{{ Form::submit('Search')}}-->
	{{ Form::close()}}
@endsection