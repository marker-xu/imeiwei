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

} // End Welcome
