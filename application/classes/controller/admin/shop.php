<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Shop extends Controller {

	public function action_index()
	{
		//$this->request->forward('guide');
		$this->template->set("abc", "kaka");
		$this->template()->set_filename("admin/shop/index");
	}

} // End Welcome
