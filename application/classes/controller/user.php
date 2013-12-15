<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller {

	public function action_login() {
		
	}
	
	public function action_index()
	{
		//$this->request->forward('guide');
		$this->response->body('hello, world!');
	}
	
	public function action_setting() {
	
	}
	
	public function action_logout() {
		
	}
} 
