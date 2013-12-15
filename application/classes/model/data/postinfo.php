<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Postinfo extends Model_Data_MongoCollection {
	
	
	public function __construct() {
		parent::__construct("cloudsearch", "mmshow", "post_info");
	}
		
	/**
	 * 
	 * Enter description here ...
	 * @param $query
	 * @param $arrParams
	 */
	public function addData($postId, $arrParams) {
		JKit::$log->debug(__FUNCTION__." id-{$postId}, params-", $arrParams);
		$arrParams['post_id'] = $postId;
		if( !isset($arrParams['create_time']) ) {
			$arrParams['create_time'] = new MongoDate();
		}
		$arrParams['update_time'] = $arrParams['create_time'];
		try {
			$arrResult = $this->getCollection()->insert($arrParams, true);
		} catch (MongoCursorException $e) {
			JKit::$log->warn("add failure, code-".$e->getCode().", msg-".$e->getMessage().", param-", $arrParams);
			
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		if($arrResult["ok"]==1) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param $query
	 * @param $arrParams
	 */
	public function modifyByPostId($postId, $arrParams, $strFrom=null) {
		JKit::$log->debug(__FUNCTION__." id-{$postId}, params-", $arrParams);
		if( !isset($arrParams['update_time']) ) {
			$arrParams['update_time'] = new MongoDate();
		}
		$arrQuery = array(
			"post_id" => $postId,
			"from" => $strFrom ? $strFrom:"fudan_mb"
		);
		try {
			$arrResult = $this->update($arrQuery, $arrParams );
		} catch (MongoCursorException $e) {
			JKit::$log->warn("add failure, code-".$e->getCode().", msg-".$e->getMessage().", param-", $arrParams);
			
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		if($arrResult["ok"]==1) {
			return true;
		}
		
		return false;
	}
	
	public function getByPostId($postId, $strFrom=null, $fields=array() ) {
		$query = array(
			"post_id" => $postId,
			"from" => $strFrom ? $strFrom:"fudan_mb"
		);
		return $this->findOne($query, $fields);
	}
}