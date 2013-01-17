<?php

class User extends Eloquent {

	public static $initial_password = '';
	public static $confirm_password = '';

	/*
	 * VALIDATION RULES
	 */ 
	public static $rules = array(
		'email' => 'required|email|unique:users,email|max:128',
		'nickname' => 'required|alpha_num|min:5|max:10',
		'password' => 'min:6|max:12|same:confirm_password',
		'gender' => 'in:male,female',
		'fullname' => 'required|alpha|max:128',
		'firstname' => 'required|alpha|max:64',
		'lastname' => 'required|alpha|max:64',
		'img_url' => 'url',
		'mantra' => 'alpha_num|max:512',
		'provider_id' => 'exists:providers',
		'is_confirmed' => 'accepted',
		'is_active' => 'accepted',
	);

	/**
	 * Getters & Setters
	 */
	public function set_password($password)
	{
	    $this->set_attribute('password', Hash::make($password));
	}

	public function get_password()
	{
	    return '';
	}

	/*
	 * RELATIONS
	 */ 

	// Hashes for register and recover password actions
	public function hashes()
	{
		return $this->has_many('Hashe');
	}

	// User has many followers
	public function followers()
	{
		return $this->has_many('Follower');
	}

	// User has many logins
	public function logins()
	{
		return $this->has_many('Login');
	}

	// User may belong to a provider
	public function provider()
	{
		return $this->belongs_to('Follower');
	}

}
