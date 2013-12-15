<?php defined('SYSPATH') or die('No direct script access.');

class Model_Logic_Sjtu {
	
	private $objModel;
	
	public function __construct() {
		$this->objModel = new Model_Data_Sjtu();
		
	}
	
	public function fetchContentByDate( $strStartDate=NULL, $strEndDate=NULL) {
		$this->objModel->setDateBetween($strStartDate, $strEndDate);
		$this->objModel->execute();
		$arrList = $this->objModel->getResult();
		$tmpArr = array();
		foreach($arrList as $k=>$row) {
			$arrList[$k] = array_merge($row, $this->objModel->fetchInfo($row['post_id'])); 
		}
		
		return $arrList;
	}
}

