<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Shop {
    
    private $strBaseUrl = "/shop";
    
    protected $strConfigName = "shop_api";
    
    /**
     * 店铺列表
     * @param int $intOffset
     * @param int $intCount
     * @return array
     */
    public function getShopList( $intOffset=0, $intCount=10 ) {
        $arrParams = array(
                "type" => "list",
                "pageno" => floor($intOffset/$intCount)
        ); 
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    /**
     * 店铺详情
     * @param int $intId
     * @return array
     */
    public function getInfo( $intId ) {
        $arrParams = array(
                "type" => "info",
                "i_id" => $intId
        );
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    /**
     * 店铺促销信息
     * @param int $intId
     * @return array
     */
    public function getPromotion( $intId ) {
        $arrParams = array(
                "type" => "promotion",
                "i_id" => $intId
        );
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    
    /**
     * 店铺促销信息
     * @param int $intId
     * @return array
     */
    public function addShopFavorite( $intId, $intUid=NULL, $strUserName=NULL ) {
        $arrParams = array(
                "type" => "insert",
                "i_id" => $intId,
        );
        if( $intUid ) {
            $arrParams["i_uid"] = $intUid;
        }
        if( $strUserName ) {
            $arrParams["s_uname"] = $strUserName;
        }
        return $this->request($this->strBaseUrl, array("post_vars" => $arrParams) );
    }
    
    public function request( $mixedAction, $arrParams=array()) {
        $strContent = Rpc::call($this->strConfigName, $mixedAction, $arrParams );
        
        if( !$strContent || !($arrResult = json_decode( $strContent, true ) ) ) {
            JKit::$log->warn( "the backend failure, action-".$mixedAction.", ret-".$strContent.", params-", $arrParams );
            return false;
        }
        if( $arrResult["retcode"]!==0 ) {
            JKit::$log->warn( "the backend response failure, code-{$arrResult["retcode"]}, msg-{$arrResult["message"]}, action-" . 
            $mixedAction . ", params-", $arrParams );
            return array();
        }
        return $arrResult["retbody"];
    }
    
    
}