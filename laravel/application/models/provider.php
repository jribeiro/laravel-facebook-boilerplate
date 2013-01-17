<?php

class Provider extends Eloquent {

	/*
	 * RELATIONS
	 */ 

	// Hashes for register and recover password actions
	public function users()
	{
		return $this->has_many('User');
	}

}