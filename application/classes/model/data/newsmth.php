<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Newsmth extends Model {
	
	private $arrDateBetween;
	
	private $arrData = array();
	
	private $arrParams = array();
	
	public function __construct( ) {
		$this->arrDateBetween = array(
			"start" => date("Y-m-d 00:00:00", strtotime("-1 day")),
			"end" =>  date("Y-m-d H:i:s")
		);
	}
	
	public function setDateBetween( $strStartDate, $strEndDate=NULL ) {
		$strStartDate = date("Y-m-d H:i:s", strtotime($strStartDate));
		if( !$strEndDate ) {
			$strEndDate = date("Y-m-d H:i:s", strtotime($strStartDate)+3600 );
		} else {
			$strEndDate = date("Y-m-d H:i:s", strtotime( $strEndDate ) );
		}
		$this->arrDateBetween = array(
			"start" => $strStartDate,
			"end" => $strEndDate
		);
	}
	
	public function execute() {
		$arrData = $this->fetch();
		$this->processData($arrData);
	}
	
	public function getResult() {
		return $this->arrData;
	}
	
	private function fetch( ) {
		$arrReturn = array();
		$arrParams = $this->arrParams;
		//非闭合，规则标签
		$strRegPattern = "/<table\s*class=\"board\-list\s*tiz\"[^>]+>\s*<thead>.*?<\/thead>\s*".
		"<tbody>(.*?)<\/tbody>\s*<\/table>/i";	
		$strReg2nd = "/<tr\s*>\s*<td\s*class=\"title\_8[^\"]*\">\s*<a[^>]+>\s*".
		"<samp class=\"tag\s*ico\-pos\-article\-([a-z0-9]+)\">\s*<\/samp>\s*<\/a>\s*<\/td>\s*".
		"<td\s*class=\"title_9[^\"]*\">\s*<a\s*href=\"([^\"]+)\">(.*?)<\/a>".
		"(\s*<samp\s*class=\"tag\-att\s*ico\-pos\-article\-attach\">\s*<\/samp>)*.*?<\/td>\s*".
		"<td\s*class=\"title_10[^\"]*\">\s*([0-9\-\:]+)[^<]*<\/td>\s*".
		"<td\s*class=\"title_12[^\"]*\">[^<]*<a[^>]+>([^<]+)<\/a>\s*<\/td>\s*".
		"<td\s*class=\"title_11[^\"]*\">\s*([0-9]+)\s*<\/td>\s*".
		"<td\s*class=\"title_10[^\"]*\">\s*<a[^>]+>\s*([0-9\-\:]+)[^<]*<\/a>\s*<\/td>\s*".
		"<td\s*class=\"title_12[^\"]*\">[^<]*<a[^>]+>([^<]+)<\/a>\s*<\/td>\s*".
		"<\/tr>/i";;
		$strUrl = "/nForum/board/PieLove?ajax";
		$arrExtra = array(
			'curl_opts' => array(
				CURLOPT_REFERER => "http://www.newsmth.net/nForum/",
				CURLOPT_HTTPHEADER => array('X-Requested-With: XMLHttpRequest')
			)
		);
		$intCurrentPage = 1;
		while(1) {
			$bolBreak = false;
			
			$strContent = Rpc::call("newsmth_api", $strUrl, $arrExtra);
			$strContent = preg_replace("/\n|\r/i","", $strContent);
//			$strContent = mb_convert_encoding($strContent, "UTF-8", "gb2312");
			preg_match($strRegPattern, $strContent, $matches);
			if( isset($matches[1]) &&  $matches[1]) {
				$strContent =  mb_convert_encoding($matches[1], "UTF-8", "gbk");
				unset($matches);
				preg_match_all($strReg2nd, $strContent, $matchTrs);
				if( isset($matchTrs[6]) &&  $matchTrs[6]) {
					$arrAuthors = $matchTrs[6];
					foreach( $arrAuthors as $k=>$strAuthor ) {
						$strDate = date("Y-m-d H:i:s", strtotime($matchTrs[5][$k]));
						$strTitle = $matchTrs[3][$k];
						if(strstr($strTitle, "撤牌") ||$this->checkStopWords( $strTitle ) ) {
							continue;
						}
						if( !$this->checkDateValid($strDate) ) {
							$bolBreak = true;
							continue;
						}
						$arrReturn[] = array(
							"title" => $strTitle, 
							"date" => $strDate, 
							"author" => $strAuthor,
							"post_id" => strtr($matchTrs[2][$k], array(
								"/nForum/article/PieLove/"=>""
							)),
							"post_count" => $matchTrs[7][$k],
							"star" => $matchTrs[1][$k],
							"attach" => $matchTrs[4][$k] ? 1:0
						);
					}
					unset($matchTrs);
				}
			}
				
				
			$intCurrentPage++;
			$arrParams["p"] = $intCurrentPage;
			
			if($bolBreak) {
				break;
			}
		}
		
		return $arrReturn;
	}
	
	private function checkDateValid( $strDate ) {
		if(!$strDate) {
			return false;
		}
		return $strDate>=$this->arrDateBetween['start'] && $strDate<$this->arrDateBetween['end'];
	}
	
	private function processData( $arrData ) {
		$arrReturn = array();
		$strGGReg = "/(征|求|觅).*?(mm|女|佳人)/i";
		$strMMReg = "/(征|求|觅).*?(gg|男|才子)/i";
		foreach($arrData as $row) {
			$row['from'] = "newsmth";
			$row['title'] = strtr($row['title'], array("○"=>"", "[代挂]"=>"", "【代挂】" => ""));
			$row['gender'] = -1;
			if(preg_match($strGGReg, $row['title'])) {
				$row['gender'] = 0;
			} elseif(preg_match($strMMReg, $row['title'])) {
				$row['gender'] = 1;
			}  elseif(preg_match("/mm|美女/i", $row['title'])) {
				$row['gender'] = 1;
			} elseif(preg_match("/gg|帅哥/i", $row['title'])) {
				$row['gender'] = 0;
			} else {
				$row['gender'] = -1;
			}
			$arrReturn[] = $row;
		}
		$this->arrData = $arrReturn;
	}
	
	public function fetchInfo( $postId ) {
		$arrReturn = array(
			"content" => "",
			"pic_list" => array(),
			"spot_pic" => ""
		);
		$strUrl = "/nForum/article/PieLove/{$postId}?ajax";
		$arrExtra = array(
			'curl_opts' => array(
				CURLOPT_REFERER => "http://www.newsmth.net/nForum/",
				CURLOPT_HTTPHEADER => array('X-Requested-With: XMLHttpRequest')
			)
		);
		$strContent = Rpc::call( "newsmth_api", $strUrl, $arrExtra );
		
		$strContent = preg_replace("/\n|\r/i","", $strContent);
//		$strContent = mb_convert_encoding($strContent, "UTF-8", "gb2312");
		$strRegPattern = "/<a\s*name=\"a0\">\s*<\/a>.*?<td\s*class=\"a-content\">(.*?)<\/td>\s*<\/tr>".
		"\s*<tr\s*class=\"a\-bottom\">/i";
		$strRegReal = "/\(([a-z]+\s*[a-z]+\s*[0-9]+\s*[0-9]{2}\:[0-9]{2}\:[0-9]{2}\s*[0-9]{4})\)".
		"[^<]+<br\s*\/>(\s*(\&nbsp;)+<br\s*\/>)*(.*?)<font\s*class=\"f[0-9]+\">/i";
		$strRegPic = "/<img.*?src=\"([^\"]+)\"[^\"]+\".*?\"[^>]*>/i";
		$strRegPicA = "/<a[^>]+>\s*<img.*?src=\"([^\"]+)\"[^\"]+\".*?\"[^>]*>\s*<\/a>/i";
		if( strstr( $strContent, "class=\"error\"") ) {
			return $arrReturn;
		}
		preg_match($strRegPattern, $strContent, $matches);
		
		if(isset($matches[1])) {
			//http://bbs.fudan.sh.cn/bbs/con?new=1&bid=120&f=975414
			$strContent = mb_convert_encoding($matches[1], "UTF-8", "gbk");
			unset( $matches );
			preg_match( $strRegReal, $strContent, $matchReal );
			if( isset($matchReal[1]) ) {
				$arrReturn['date'] = date("Y-m-d H:i:s", strtotime( $matchReal[1] ) );
				$arrReturn['content'] = preg_replace($strRegPic, "<img src='$1' />", $matchReal[4]);
				preg_match_all($strRegPic, $strContent, $matchPic);
				if( isset( $matchPic[1] ) && $matchPic[1] ) {
					$arrReturn['pic_list'] = $matchPic[1] ;
					$arrReturn['spot_pic'] = $arrReturn['pic_list'][0];
				}
			}
			
		}
		
		return $arrReturn;
	}
	
	private function checkStopWords( $strTitle ) {
		$strReg = "/yc|被暂停|发文权限|十大|撤牌|(主|陪)挂.+?号|被取消|re/i";
		return preg_match($strReg, $strTitle);
	}
}