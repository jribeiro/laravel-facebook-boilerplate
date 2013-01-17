<?php

HTML::macro('flash', function() 
{
	//dd(Session::dump());
	if(!Session::has('flash'))
		return ;
	Session::reflash('flash');

	$data = Session::get('flash');
    $status = (array_key_exists('status', $data)) ? $data['status'] : '';
    $message_heading = (array_key_exists('heading', $data)) ? $data['heading'] : '';
    $message_content = (array_key_exists('content', $data)) ? $data['content'] : '';
    $message_badge = (array_key_exists('badge', $data)) ? $data['badge'] : '';

    if(!empty($message_badge)) {
    	$message = '
    		<div class="row-fluid">
    			<div class="span6 pull-left">
    				<h4 class="alert-heading">
    					'.$message_heading.'
    				</h4>
    				<p>
    					'.$message_content.'
    				</p>
    			</div>
    			<div class="span2 pull-right">
    				<div class="glyph">
						<span class="user-badge warning bigger" aria-hidden="true" data-icon="r"></span>
					</div>
    			</div>
    		</div>';
    }
    else {
    	$message = '
    		 <div class="row-fluid">
				<h4 class="alert-heading">
					'.$message_heading.'
				</h4>
				<p>
					'.$message_content.'
				</p>
    		</div>';
    }
    
    switch ($status) {
    	case 'success':
    		echo Alert::success($message)->block();
    		break;
		case 'warning':
    		echo Alert::warning($message)->block();
    		break;
    	case 'error':
    		echo Alert::error($message)->block();
    		break;
    	default:
    		echo Alert::info($message)->block();
    		break;
    }

});