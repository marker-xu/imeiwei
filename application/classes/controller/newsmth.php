<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Newsmth extends Controller {

	public function before() {
		parent::before();
		header("Content-Type: text/html; charset=utf-8;");
	}
	
	public function action_index()
	{
		//$this->request->forward('guide');
		$this->response->body('hello, world!');
	}
	
	public function action_test() {
		//抓取
		$objSjtu = new Model_Data_Newsmth();
//		$objSjtu->execute();
//		print_r($objSjtu->getResult());
		
		//抓取实体内容
		$postId = "2061628";
		print_r( $objSjtu->fetchInfo($postId) );
		$this->ok();
	}
	
} // End Welcome
