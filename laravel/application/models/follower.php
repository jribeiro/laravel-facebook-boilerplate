<?php

class Follower extends Eloquent {

	public static $timestamps = false;

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

	// User may belong to a provider
	public function provider()
	{
		return $this->belongs_to('Follower');
	}

}
