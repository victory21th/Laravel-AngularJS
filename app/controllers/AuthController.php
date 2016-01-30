<?php
/*
*	CardShare Web Controller Side
*	File Name 			: 	AuthController.php
*	File Description	:	Auth Controller to Control Login and Logout with authentication
*	Created Date 		:	11 - Nov - 2014
*	Last Modified Date 	:	25 - Nov - 2014
*	Company				:	iExemplar
*	Created By			:	Allen Emanuel Raj D
*	Contributors		:	Allen Emanuel Raj D
**/
class AuthController extends BaseController {

	public function status() {
		return Response::json(Auth::check());
	}

	public function secrets() {
		if(Auth::check()) {
			return 'You are logged in, here are secrets.';
		}else{
			return 'You aint logged in, no secrets for you.';
		}
	}

	public function login()
	{
		if(Auth::attempt(array('username' => Input::json('email'), 'password' => Input::json('password')),true))
		{
			return Response::json(Auth::user());
		}else{
			return Response::json(array('flash' => 'Invalid username or password'), 401);
		}
	}

	public function testUser()
	{
		$creds = array('username' => 'superadmin', 'password' => 'superadmin' );

		return (Auth::validate($creds) ? 'Match!' : 'No Match!');
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

	public function hasChannelRight()
	{
		$channel_id = Input::json('channel_id');
		$requested_ch_right = Input::json('channel_right');;
		$usergroup = User::find(Auth::id())->usergroup()->first();

		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$Right_list = DB::select(DB::raw(
			"SELECT ugchr.* FROM usergroupchannelrights ugchr, channelsrights chr
				WHERE ugchr.Channel_Id = ".$channel_id." and ugchr.UserGroup_Id = ".$usergroup->UserGroup_Id."
					and ugchr.Channel_Right_Id =  chr.ChannelRight_Id
					and chr.Channel_Right_Name = '".$requested_ch_right."'"));

		return Response::json(count($Right_list) >0);
	}






}
