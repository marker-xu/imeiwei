<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Fudan extends Controller {

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
		$objFudan = new Model_Data_Fudan();
//		$objFudan->execute();
//		print_r($objFudan->getResult());
		
		//抓取实体内容
		$postId = "3085070402";
		print_r( $objFudan->fetchInfo($postId) );
		$this->ok();
	}
	
	public function action_single() {
		//抓取
		$objFudan = new Model_Data_Fudan();
		$objFudan->isSingle(true);
		$objFudan->execute();
		print_r($objFudan->getResult());
		
		//抓取实体内容
		$postId = "3085070402";
		print_r( $objFudan->fetchInfo($postId) );
		$this->ok();
	}	
} // End Welcome
