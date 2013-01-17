<?php

class Helper {

    public static function fbLogin(){

        // Load the facebook sdk bundle
		Bundle::start('facebook-sdk');

		// create a facebook object instance
		$facebook = IoC::resolve('facebook-sdk');

		// set parameters for the facebook request
		$params = array(
		    'redirect_uri' => URL::to('connect/facebook'),
		    'scope' => 'email, user_about_me',
		);

		// returns the facebook url 
		return $facebook->getLoginUrl($params);
    }

    public static function printFlashes()
    {
    	if(Session::has('flash')) {
			Session::reflash('flash');
			//Session::dump();
	        echo HTML::flash(Session::get('flash'));
	    }

    }

}