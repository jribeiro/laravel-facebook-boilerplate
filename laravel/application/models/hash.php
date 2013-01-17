<?php

class Hashe extends Eloquent {

	public static $table = 'hashes';

	public function user()
	{
		return $this->belongs_to('User');
	}

}
