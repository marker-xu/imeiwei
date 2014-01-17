<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Api extends Controller {
	
	public function action_get_region_async() {
	    $province = $this->request->param("province");
	    $all = $this->request->param("all");
	    $path = DOCROOT . 'resource/js/third/region/region.json';
	    $provinces = json_decode(file_get_contents($path), true);
	    
	    $result = array();
	    
	    // 如果all==1，返回该省的四级以内的地址和其他省的一级地址，否则直接返回该省的信息
	    if($all == '1') {
	        foreach($provinces as $key => $item) {
	            if($item[0] == $province ||
	            $this->reduceProvinceName($item[0]) === $province) {
	                $result[$key] =$item;
	            } else {
	                $result[$key] = array(
	                        0 => $item[0]
	                );
	            }
	        }
	    } else {
	        foreach($provinces as $key => $item) {
	            if($item[0] == $province ||
	            $this->reduceProvinceName($item[0]) === $province) {
	                $result = $item;
	                break;
	            }
	        }
	    }
	    $this->ok( $result );
	}

	public function action_get_town() {
	    $district_id =  intval( $this->request->param("district_id") );
	    $path = DOCROOT . 'resource/js/third/region/town/' . $district_id . '.json';
	    if(file_exists($path)) {
	        $arrTmp = json::decode(file_get_contents($path), true);
	        $this->ok($arrTmp);
	    } else {
	        $this->err(null, "the dstrict not exists");
	    }
	}
} // End Welcome
