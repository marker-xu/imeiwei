<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Shop extends Controller {
    
    public function before() {
        parent::before();
        $this->template->set("current_action", $this->request->action() );
    }

	public function action_index()
	{
		//$this->request->forward('guide');
		$this->template->set("abc", "kaka");
	}
	
	public function action_environment() {
	}

	public function action_env_add() {
	}

	public function action_category() {
	}

	public function action_hours() {
	}

	public function action_preferential() {
	}

	public function action_takeaway() {
	}

} // End Welcome
