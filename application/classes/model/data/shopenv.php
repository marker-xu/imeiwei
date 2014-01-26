<?php 

/**
 * 商铺环境
 * @author xucongbin
 */
class Model_Data_Shopenv extends Model_Data_MongoCollection {
    
	public function __construct() {
        parent::__construct('shop_env_photo');
	}
	
	public function addShopEnv( $intShopId, $arrParams ) {
	    $arrParams["_id"] = self::getUniqueCode("shop_env");
	    $arrParams["shop_id"] = $intShopId;
	    if( !isset($arrParams['create_time']) ) {
	        $arrParams['create_time'] = new MongoDate();
	    }
	    $arrParams['update_time'] = $arrParams['create_time'];
	    $arrResult = $this->insert( $arrParams );
	    if( $arrResult["ok"]==1 ) {
	        return $arrParams["_id"];
	    }
	    return false;
	}
	
	public function initEnvStoreDir( $intShopId ) {
	    $strPathName = $this->getEnvStoreDir($intShopId);
	    if( !is_dir($filename) ) {
	        @mkdir($strPathName, 0666, true);
	    }
	}
	
	public function getEnvStoreDir( $intShopId ) {
	    return DOCROOT."shop_env/{$intShopId}";
	}
}