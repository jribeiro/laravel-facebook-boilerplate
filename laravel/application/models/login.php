<?php

class Login extends Eloquent {

	public static $timestamps = false;

	/*
	 * RELATIONS
	 */ 

	// Hashes for register and recover password actions
	public function user()
	{
		return $this->belongs_to('User');
	}

}
