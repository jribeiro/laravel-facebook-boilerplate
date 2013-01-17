@section('topmenu')
<?php echo  Navbar::create()
    ->with_brand('Mark.io', URL::base())
    ->with_menus(
    	Navigation::links(
        array(
        	array('<img class="user-avatar" src="https://graph.facebook.com/'.$userId.'/picture?type=square" alt="'.$name.'"/> '.$name, '#', false, false,
            	array(
	              array('Update', '#'),
	              array('Privacy', '#'),
	              array('Logout', URL::to('logout')),
	            )
	          )
	        )
    	),
    	array('class' => 'pull-right')
	);?>
@endsection