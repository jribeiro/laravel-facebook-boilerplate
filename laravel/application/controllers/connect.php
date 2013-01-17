<?php

class Connect_Controller extends Base_Controller 
{

	public $restful = true;

	/**
	 * Future implementation of other providers: Google, Github, Twitter, etc...
	 */
	public function get_index($provider){

		Bundle::start('laravel-oauth2');

		$provider = OAuth2::provider($provider, array(
			'id' => '295809523873114',
			'secret' => '9ad718fee307c9a7e1acba8efa480744',
			//'redirect_url' => 'http://mark.dev/connect/facebook',
		));

		if(!Input::get('code')) return $provider->authorize();
	
		try{

			$params = $provider->access(Input::get('code'));
			$token = new OAuth2_Token_Access(array(
				'access_token' => $params->access_token
			));

			$user_oauth = $provider->get_user_info($token);

			// Do something with the token here!

		} catch(OAuth2_Exception $e){
			echo "Oops! $e";
		}

	}

	public function get_facebook(){

		Bundle::start('facebook-sdk');

		// if we get an error from facebook redirect to home 
		if(Input::get('error')){
		    return $this->_redirectHome();
		}

		$facebook = IoC::resolve('facebook-sdk');
		$uid = $facebook->getUser();

		// Something wrong happened here. No id is present
		if(empty($uid)) return $this->_redirectHome();

		// let's grab some info
		$fbUser = $facebook->api('/me');
		//dd($fbUser);
		// user has already signed up, we should update some info here 
		if($user = User::find($fbUser['id'])){
			// Save users following
			$this->_saveFriends($facebook, $user);

			return $this->_doFacebookLogin($user);

		}
	
		// let's check if the user has registered with his email before
		else if($user = User::where('email', '=', $fbUser['email'])->first()){
			$user->id = $fbUser['id'];
			$user->save();

			// Save users following
			$this->_saveFriends($facebook, $user);
			
			return $this->_doFacebookLogin($user);
		}
		// yey, we have a new user!!!
		else{
			$user = User::create(
				array(
					'id' => $fbUser['id'],
					'email' => $fbUser['email'],
					'nickname' => $fbUser['username'],
					'fullname' => $fbUser['name'],
					'firstname' => $fbUser['first_name'],
					'lastname' => $fbUser['last_name'],
					'gender' => $fbUser['gender'],
					'provider_id' => 1,
					'is_confirmed' => $fbUser['verified'],
					'mantra' => $fbUser['bio'],
				)
			);

			// TODO: If some error happens we should save what we can to session and direct user to the registration form pre-filled
			if(!$user->save()) return $this->_redirectHome(); 

			// Save users following
			$this->_saveFriends($facebook, $user);

			// Say hi to the user
			Session::flash('flash', array(
				'status' => 'info',
				'heading' => 'Welcome Mark\'er',
				'content' => "You've just won the early adopter badge!",
				'badge' => "early-adopter",
			));

			return $this->_doFacebookLogin($user)->with('first-login', true);

		}

	}

	/**
  	 * Provided an user id, checks if he's in the allowed user lists and handles login and redirect
	 *
	 * @param $userId
	 * @version 0.01
	 *
	 * @todo Pass up friends to worker
	 */
	private function _doFacebookLogin($user){
		
		if(!betaAllowedId::where('fbId', '=', $user->id)->first()) return Redirect::to('/beta');

			// create a new Login record for the user
			$user->logins()->insert(array());

			// Authenticate our mark'er
			Auth::login($user->id);

			return Redirect::to('/home');
	}

	/**
  	 * Saves user facebook friends as followers
	 *
	 * @param User object to connect friends with
	 * @param date in Y-mm-dd format
	 */
	private function _saveFriends($facebook, $user, $since = ''){

		if(empty($user)) return false;

		$sinceStr = (empty($since)) ? "" : "&since=$since";

		// let's grab the facebook friends
		$fbFriends = $facebook->api("/me/friends$sinceStr");
		
		if(empty($fbFriends) || !array_key_exists('data', $fbFriends)) return false; // unexpected

		// If the user has followers, let's iterate and only insert the ones not present
		if(Follower::where('user_id', '=', $user->id)->count() == 0){
			foreach ($fbFriends['data'] as $friend) {
				$followers[] = array(
					'friend_id' => $friend['id'],
					'fullname' => $friend['name'],
				);
			}
			
			$user->followers()->save($followers);
		}
		else {
			foreach ($fbFriends['data'] as $friend) {
				if(!Follower::where('user_id', '=', $user->id)
						->where('friend_id', '=', $friend['id'])->first()){
					$follower = array(
						'friend_id' => $friend['id'],
						'fullname' => $friend['name'],
					);
					$user->followers()->insert($follower);	
				}
			}
		}
		
		// Now let's find the users already on system and activate them
		DB::query('UPDATE followers INNER JOIN users ON (users.id = followers.friend_id) SET 
						is_markio_friend = true,
						confirmed_on = CURRENT_TIMESTAMP 
					WHERE user_id = '.$user->id);

		// And we need to update our connection to others
		DB::query('UPDATE followers SET 
						is_markio_friend = true,
						confirmed_on = CURRENT_TIMESTAMP 
					WHERE friend_id = '.$user->id);			

		return true;
	}

	private function _redirectHome(){
		// TODO: an error message should be thrown
		return Redirect::to('/');
	}

}