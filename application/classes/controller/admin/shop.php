<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Shop extends Controller {
    
    public function before() {
        parent::before();
        $this->template->set("current_action", $this->request->action() );
    }

	public function action_index()
	{
		//$this->request->forward('guide');
		$arrRules = $this->_formRule(array('@shop_name', '@address'));	
		if($this->request->method()!='POST') {
			$objCommon = new Model_Data_Common();
			$this->template->set("cuisine_list", $objCommon->getCuisineList());
			return;
		}
		$arrPost = $this->request->post();
		$objValidation = new Validation($arrPost, $arrRules);
		if (! $this->valid($objValidation)) {
			return;
		}
		$objModelShop = new Model_Data_Shop();
		$strShopName = trim( $arrPost["shop_name"] );
		$arrParams = array(
		        "s_addr" => $arrPost["shop_address"],
		        "j_tel_number" => is_array( $arrPost["phone"] ) ? $arrPost["phone"]: (array) $arrPost["phone"],
		        "j_tags" => array($arrPost["cuisine"]),
		        "i_boss_uid" => $this->_uid
		);
		$res = $objModelShop->addShopInfo($strShopName, $arrParams);
		if ( !$res ) {
		    $this->err(null, "用户创建失败！");
		}
		
		$this->ok();
	}
	
	public function action_environment() {
	}

	public function action_env_add() {
	    if($this->request->method()!='POST') {
	        $this->template->set("shop_id", 12345);
	        return;
	    }
	    $avatar = $_FILES['shop_photo'];
	    $validAvatar = $this->validAvatar($avatar);
	    if( !$validAvatar['ok'] ) {
	        $this->avatarCB(false, '', $validAvatar['msg']);
	    }
	}

	public function action_category() {
	}

	public function action_hours() {
	}

	public function action_preferential() {
	}

	public function action_takeaway() {
	}

	protected function _formRule($arrField = null) {
	    $arrRules = array(
            '@email' => array(
                   	'datatype' => 'email',
                   	'errmsg' => '邮箱格式错误',
            ),
            '@name' => array(
                    'datatype' => 'reg',
                    'reqmsg' => '用户名',
            		'reg-pattern' => "/^[\u4e00-\u9fa5\_a-zA-Z\d\-0-9]{2,10}$/",
            ),
            '@shop_name' => array(
                    'datatype' => 'text',
                    'reqmsg' => '商户名称',
                    'maxlength' => 20
            ),
			'@address' => array(
                    'datatype' => 'text',
                    'reqmsg' => '地址',
                    'maxlength' => 20
            ),
	    );

	    if ($arrField == null) {
	        $arrRes = $arrRules;
	    } else {	    
    	    $arrRes = array();
    	    foreach ($arrField as $v) {
    	        $arrRes[$v] = $arrRules[$v];
    	    }
	    }
	    
	    return $arrRes;
	}
    
	/**
	 * @param array $avatar Array (
	 [name] => Water lilies.jpg
	 [type] => image/jpeg
	 [tmp_name] => /tmp/phpeFK8jV
	 [error] => 0
	 [size] => 83794
	 )
	 */
	private function validShopLogo($avatar) {
	    $arrReturn = array(
	            'ok' => false,
	            'msg' => ''
	    );
	    if(! $avatar['tmp_name']) {
	        $arrReturn['msg'] = "头像不能为空";
	        return $arrReturn;
	    }
	
	    if($avatar['error'] !== UPLOAD_ERR_OK) {
	        $arrReturn['msg'] = "头像上传失败";
	        return $arrReturn;
	    }
	
	    $arrImgAttr = getimagesize($avatar['tmp_name']);
	    $arrValidType = array(IMAGETYPE_GIF => true, IMAGETYPE_PNG => true,
	            IMAGETYPE_JPEG => true);
	    if(! is_array($arrImgAttr) || ! isset($arrValidType[$arrImgAttr[2]])) {
	        $arrReturn['msg'] = "图片格式错误";
	        return $arrReturn;
	    }
	    $arrReturn['attr'] = $arrImgAttr;
	
	    $maxSizeLimit = 5242880;
	    if($avatar['size'] > $maxSizeLimit) {
	        $arrReturn['msg'] = "图片大小不能超过5M";
	        return $arrReturn;
	    }
	    $arrReturn['ok'] = true;
	    return $arrReturn;
	}
} // End Welcome
