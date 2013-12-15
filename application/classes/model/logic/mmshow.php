<?php defined('SYSPATH') or die('No direct script access.');

class Model_Logic_Mmshow {
	
	private $objModelPostlist;
	private $objModelPostinfo;
	
	public function __construct() {
		$this->objModelPostlist = new Model_Data_Postlist();
		$this->objModelPostinfo = new Model_Data_Postinfo();
	}
	
	public function getPostList( $arrDateBetween=null, $intOffset=0, $intCount=20 ) {
		$arrReturn = array();
		$query = array(
			"from" => "fudan_mb"
		);
		if($arrDateBetween) {
			$query['date'] = array(
				'$gte' => date("Y-m-d H:i:s", strtotime($arrDateBetween['start'])),
				'$lt' => date("Y-m-d H:i:s", strtotime($arrDateBetween['end']))
			);
		}
		$fields = array(
			"title", "date", "author", "gender", "spot_pic", "from", "post_id", "post_count"
		);
		$sort = array(
			"date" => -1
		);
		$limit = $intCount;
		$skip = 0;
		unset($query['from']);
		$arrReturn = $this->objModelPostlist->find($query, $fields, $sort, $limit*3, $skip);
		return array_slice($arrReturn, $intOffset, $intCount);
		//fudan
		$arrFudanMb = $this->objModelPostlist->find($query, $fields, $sort, $limit, $skip);
		//single
		$query['from'] = "fudan_single";
		$arrFudanSingle = $this->objModelPostlist->find($query, $fields, $sort, $limit, $skip);
		//sjtu
		$query['from'] = "sjtu";
		$fields[] = "post_count";
		$arrSjtu = $this->objModelPostlist->find($query, $fields, $sort, $limit, $skip);
		
		$arrReturn = array_merge($arrFudanMb, $arrFudanSingle, $arrSjtu);
//		shuffle($arrReturn);
		return array_slice($arrReturn, $intOffset, $intCount);
	}
	
	public function getPostInfo($strFrom, $postId) {
	
		return $this->objModelPostinfo->getByPostId($postId, $strFrom);
	}
	
	public function getRecommendResult( $intCount=10 ) {
		$arrReturn = array();
		$arrDateBetween = array(
			"start" =>date("Y-m-d", strtotime("-5 day"))." 00:00:00",
			"end" =>date("Y-m-d H:i:s"),
		);
		$arrResult = $this->getPostList($arrDateBetween, 0, 100);
		$arrExtra = array();
		foreach($arrResult as $row) {
			$tmp = array(
					"title" => $row['title'], 
					"title" => strtr(strip_tags( $row['title'] ), array("&nbsp;"=>" ", "【"=>"[", "】"=>"]")), 
					"date" => $row['date'], 
					"author" => $row['author'], 
					"gender" => $row['gender'], 
					"spot_pic" => $row['from']!="sjtu" || !$row['spot_pic']  
						? $row['spot_pic']:"http://".DOMAIN_SITE."/sjtu/piccontent?f=".$row['spot_pic'], 
					"from" => $row['from'], 
					"post_id" => $row['post_id']
				);
			if( $row['spot_pic'] && $row['gender']==1 ) {
				$arrReturn[] = $tmp;
			} elseif( $row['spot_pic'] || $row['gender']==1 ) {
				$arrExtra[] = $tmp;
			}
		}
		$arrReturn = array_merge($arrReturn, $arrExtra);
		return array_slice( $arrReturn, 0, $intCount );
	}
	
	public function getSjtuImageContent( $strFile ) {
		$arrReturn = array(
			"mime" => "image/jpg",
			"content" => ""
		);
		$objModelImgdata = new Model_Data_Imgdata();
		
		$arrData = $objModelImgdata->getByFile($strFile, "sjtu");
		if( $arrData ) {
			$arrReturn["content"] = $arrData['data']->bin;
			$arrReturn["mime"] = $arrData['mime'];
			return $arrReturn;
		}
		$arrExtra = array(
			'curl_opts' => array(
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.31 (KHTML, like Gecko)".
				" Chrome/26.0.1410.64 Safari/537.31"
			)
		);
		
		$strContent = Rpc::call( "sjtu_api", $strFile, $arrExtra );
		if(!$strContent) {
			$strContent = Rpc::call( "sjtu_api", $strFile, $arrExtra );
		}
		
		if(!$strContent) {
			return $arrReturn;
		}
		
		$tmpFileName = "/tmp/".uniqid("sjtu").".jpg";
		file_put_contents($tmpFileName, $strContent);
		$strMime = mime_content_type( $tmpFileName );
		$intImgWidth = 500;
		$objImage = Image::factory($tmpFileName);
		if( $objImage->width<$intImgWidth ) {
			$intImgWidth = $objImage->width;
		}
		$objImage->resize($intImgWidth, NULL, Image::WIDTH);
		$objImage->save($tmpFileName);
		$strContent = file_get_contents($tmpFileName);
		@unlink($tmpFileName);
		$arrParams = array(
			"mime" => $strMime ? $strMime:"image/jpg",
			"from" => "sjtu",
			"data" => new MongoBinData($strContent)
		);
		$objModelImgdata->addData($strFile, $arrParams);
		$arrReturn["content"] = $strContent;
		$arrReturn["mime"] = $strMime;
		
		return $arrReturn;
	}
	
	public function resizeAvatar( $sourceImage ) {
		$strOrgTmpName = "/tmp/".uniqid("org").".png";
		$strContent = file_get_contents($sourceImage);
		if(!$strContent || preg_match("/<script[^>]*>/i", $strContent)) {
			throw new Model_Logic_Exception("download failure", -2002);
		}
		$res = file_put_contents($strOrgTmpName, $strContent);
		if(!$res) {
			throw new Model_Logic_Exception("download failure", -2001);
		}
//		$intMaxWidth = 400;
//		$intMaxHeight = 300;
//		$objImage = Image::factory($strOrgTmpName);
//	    $imageMaster = Image::AUTO;
//	    $diff = $objImage->width - $objImage->height;
//	    if($diff>0) {
//	        $imageMaster = Image::HEIGHT;
//	    } elseif($diff<0) {
//	        $imageMaster = Image::WIDTH;
//	    }
//	    $objImage->resize($intMaxWidth, $intMaxHeight, $imageMaster);
//	    $objImage->save($strOrgTmpName);
//	    unset($objImage);
    	$thumb200TmpName = "/tmp/".uniqid("200").".jpg";
//    	$thumb150TmpName = "/tmp/".uniqid("150").".jpg";
		$objImage = Image::factory($strOrgTmpName);
		$objImage->resize(200, NULL, Image::WIDTH);
		$objImage->save($thumb200TmpName, 85);
//		$objImage->resize(150, 100);
//		$objImage->save($thumb150TmpName, 85);
		@unlink($strOrgTmpName);
//		echo $thumb200TmpName;
		return array(
			200 => $thumb200TmpName,
//			150 => $thumb150TmpName,
		);
	}
}

