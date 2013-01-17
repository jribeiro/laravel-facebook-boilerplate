<?php

class Users_Controller extends Base_Controller {

	public $restful = true;

	public function get_view ($username){
		return View::make('users.view')
			->with('user' => User::where('nickname','=',$username)->first());
	}

	public function get_update ($id){

		$input = array(
		    'username' => Input::get('username',$user->username);
		);
		if(Input::get('password',false) !== false) $input['password'] = Input::get('password');

		$rules = array(
		    'password' => 'min:8|alpha_num',
		);
		
	}
}