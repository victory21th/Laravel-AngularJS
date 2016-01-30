<?php
/*
*	Trigger Simple SMTP Mail
*
**/
class MailController extends BaseController {

	public function sendMail(){
		Mail::send('hello', array('mail_to' => Input::json('mail_to'), 'mail_subject' => Input::json('mail_subject')), function($message)
		{
			$message->to(Input::json('mail_to'), 'John Smith')->subject(Input::json('mail_subject'));
		});
		return Response::json(array('flash' => 'Mail Sent Successfully!!!!!'));
	}
}
