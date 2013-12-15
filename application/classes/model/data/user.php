<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_User extends Model_Data_MongoCollection {
	
	
	public function __construct() {
		parent::__construct("cloudsearch", "qidian", "users");
	}
	
	/**
	 * 查询单个用户的信息
	 * @param string $id
	 * @param array $fields
	 * @return array|null
	 */
	public function get($id, $fields = array())
	{
	    return $this->findOne(array('id' => strval($id)), $fields);
	}
	
	/**
	 * 查询多个用户的信息
	 * @param array $ids
	 * @param array $fields
	 * @param bool $keepOrder 是否保持传入参数中ID的顺序
	 * @return array
	 */
	public function getMulti($ids, $fields = array(), $keepOrder = false) 
	{
	    if (!$ids) {
	        return array();
	    }
	    $users = $this->find(array('id' => array('$in' => $ids)), $fields);
	    if ($keepOrder) {
	        $tmp = array();
	        foreach ($ids as $id) {
	            if (isset($users[$id])) {
	                $tmp[$id] = $users[$id];
	            }
	        }
	        $users = $tmp;
	    }
	    return $users;
	}
	/**
	 * 根据昵称查询多个用户的信息
	 * @param array $arrNick
	 * @param array $fields
	 * @param bool $keepOrder 是否保持传入参数中ID的顺序
	 * @return array
	 */
	public function getMultiByNick($arrNick, $fields = array())
	{
	    if (empty($arrNick)) {
	        return array();
	    }
	    $users = $this->find(array('name' => array('$in' => $arrNick)), $fields);

	    return $users;
	}
		
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $account
	 * @param unknown_type $arrParams
	 * 
	 * @reutrn int|boolean uid
	 */
	public function addUser($email, array $arrParams) {
		JKit::$log->debug(__FUNCTION__." email-{$email}, params-", $arrParams);
		if(!isset($arrParams['id'])) {
			$arrParams['id'] = $this->getUniqueValue("user");
		} 
		$arrParams['email'] = strtolower($email);
		if( !isset($arrParams['name']) ) {
			$arrParams['name'] = $arrParams['email'];
		}
		
		if( !isset($arrParams['create_time']) ) {
			$arrParams['create_time'] = new MongoDate();
		}
		$arrParams['update_time'] = $arrParams['create_time'];
		$arrParams['last_login_time'] = $arrParams['create_time'];
		if( !isset($arrParams['last_login_ip']) ) {
			$arrParams['last_login_ip'] = Request::$client_ip;
		}
		
		try {
			$arrResult = $this->getCollection()->insert($arrParams, true);
		} catch (MongoCursorException $e) {
//			echo "addUser failure, code-".$e->getCode().", msg-".$e->getMessage()."<br>\n";
			JKit::$log->warn("addUser failure, code-".$e->getCode().", msg-".$e->getMessage().", param-", $arrParams);
			
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		if($arrResult["ok"]==1) {
			return $arrParams['id'];
		}
		
		return false;
	}
	/**
	 * 
	 * Enter description here ...
	 * @param string $email
	 * @param int $excludeId
	 */
	public function getByEmail($email, $excludeId=NULL) {
		$query = array(
			'email' => strtolower($email)
		);
		if ($excludeId!==NULL) {
			$query['id'] = array('$ne'=>strval($excludeId));
		}
		return $this->findOne($query);
	}
	/**
	 * 
	 * Enter description here ...
	 * @param string $nick
	 * @param int $excludeId
	 */
	public function getByNick($nick, $excludeId=NULL) {
		$query = array(
			'name' => $nick
		);
		if ($excludeId!==NULL) {
			$query['id'] = array('$ne'=>strval($excludeId));
		}
		return $this->findOne($query);
	}
	/**
	 * 
	 * 更新用户信息
	 * @param int $uid
	 * @param array $arrParams
	 * @throws Model_Data_Exception
	 */
	public function modifyById($uid, array $arrParams) {
		JKit::$log->debug(__FUNCTION__." uid-{$uid}, params-", $arrParams);
		if ( !$this->get($uid) ) {
			throw new Model_Data_Exception("user({$uid}) not exists", -3001, NULL);
		}
		if(!isset($arrParams['update_time'])) {
			$arrParams['update_time'] = new MongoDate();	
		}
		
		$query = array('id' => strval($uid) );
		try {
			$arrResult = $this->getCollection()->update($query, array('$set'=>$arrParams), array("safe"=>true));
		} catch (MongoCursorException $e) {
			JKit::$log->warn("modifyUser failure, code-".$e->getCode().", msg-".$e->getMessage().", uid-{$uid}, param-", $arrParams);
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		return isset($arrResult["ok"]) && $arrResult["ok"]==1 ? true : false;
	}
	
	private function getUniqueCode($collectionName, $step=1) {
		$strCode = 'db.unique_coll.findAndModify({query:{name:"'.$collectionName.
		'"}, update:{$inc:{max:'.intval($step).'}}, new:true, upsert:1}).max';
		
		return $strCode;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $collectionName
	 * @param int $step
	 * 
	 * @return int;
	 */
	public function getUniqueValue($collectionName, $step=1) {
		return md5($collectionName.microtime(true));
		$strCode = $this->getUniqueCode($collectionName, $step);
		$arrReturn =  Database::instance("web_mongo")->getMongoDB('video_search')->execute($strCode);
		
		return $arrReturn['retval'];
	}
}