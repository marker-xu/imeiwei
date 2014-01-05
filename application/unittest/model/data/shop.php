<?php defined('SYSPATH') or die('No direct script access.');

class ModelDataRecommendTest extends UnitTestCase {
	private $_model;
    
    function __construct()
    {
        parent::__construct();
        
        $this->_model = new Model_Data_Shop();
    }
    
    function setUp()
    {
    }
    
    function tearDown()
    {
    }
    
    public function test_getShopList() {
//     	return;
    	$intOffset = "10";
    	$intCount = 10;
    	$arr  = $this->_model->getShopList( $intOffset, $intCount );
    	print_r($arr);
    	$this->assertIsA($arr);
    }
    
    public function test_getInfo() {
        return;
    	$intId = 12;
    	$arr  = $this->_model->getInfo($intId);
    	print_r($arr);
    	$this->assertIsA($arr);
    }
    
    public function test_getPromotion() {
//     	return;
		$intId = "10";
    	$arr  = $this->_model->getPromotion($intId);
    	print_r($arr);
    	$this->assertIsA($arr);
    }
    public function test_buildData() {
    	return;


    }
    
    public function test_buildUserCircleAndVideo() {
    	return;
    }
    
    public function test_getUserCircles() {
        return;
    	
    }
    
    public function test_relatedCircles() {
        return;
    }
    
    public function test_videoRecommendReason()
    {
        $result = array('d3118018a75f59235ea4ba9a9dcd8b1d', 'e84141846d751f8e8e4e73e62290e26a', 
            'aa8e7bd89271ba7e70042b4fdb266d61');
    	$this->assertTrue($result);
    }
}