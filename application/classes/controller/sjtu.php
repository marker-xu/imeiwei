<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sjtu extends Controller {

	public function before() {
		parent::before();
	}
	
	public function action_index()
	{
		//$this->request->forward('guide');
		$this->response->body('hello, world!');
	}
	
	public function action_test() {
		//抓取
		$objSjtu = new Model_Data_Sjtu();
		$objSjtu->execute();
		print_r($objSjtu->getResult());
		
		//抓取实体内容
		$postId = "1368895611";
		print_r( $objSjtu->fetchInfo($postId) );
		$this->ok();
	}
	
	public function action_piccontent() {
		$strImgFile = $this->request->query("f");
		if(strstr($strImgFile, "bbs.sjtu.edu.cn")) {
			$arrTmp = explode("bbs.sjtu.edu.cn", $strImgFile);
			$strImgFile = $arrTmp[1];
		}
		$objLogicMmshow = new Model_Logic_Mmshow();
		$arrData = $objLogicMmshow->getSjtuImageContent( $strImgFile );
		$strUrl = $strImgFile;
		
		$this->response->headers('Content-Type', $arrData["mime"]);
		$expire = 360*86400;
		$this->response->headers('Cache-Control', "max-age=$expire, public");
    	$this->response->headers('Expires', gmdate('D, d M Y H:i:s', time() + $expire) . ' GMT');
		$this->response->body( $arrData['content'] );
	}
	
} // End Welcome
