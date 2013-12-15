<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Sjtu extends Model {
	
	private $arrDateBetween;
	
	private $arrData = array();
	
	private $arrParams = array();
	
	public function __construct( ) {
		$this->arrDateBetween = array(
			"start" => date("Y-m-d H:i:s", strtotime("-1 day")),
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
		$strRegPattern = "/<tr>\s*<td>([0-9]+)<\/td>\s*".
		"<td>[a-z]?<\/td>\s*".
		"<td>\s*<a\s*href=\"([^\"]+)\">([^\<]+)<\/a>\s*<\/td>\s*".
		"<td>([^<]+)<\/td>\s*".
		"<td>\s*<a\s*href=\"([^\"]+)\">([^\<]+)<\/a>([^\<]+)\s*<\/td>\s*<\/tr>/i";
		$strRegPattern = "/<tr>\s*<td>([0-9]+)\s*".
		"<td>[a-z]?\s*".
		"<td>\s*<a\s*href=\"([^\"]+)\">([^\<]+)<\/a>\s*".
		"<td>([^<]+)\s*".
		"<td>\s*<a\s*href=\"?([^\"]+)\"?>([^\<]+)<\/a>([^\<]+)\s*/i";		
		$strReg2nd = "/<hr>\s*<a\s*href=\"([^\"]+)\"\s*>/i";
		$strUrl = "/bbstdoc,board,LoveBridge.html";
		$arrExtra = array(
				'curl_opts' => array(
					CURLOPT_SSL_VERIFYPEER => 0,
					CURLOPT_SSL_VERIFYHOST => 0,
					CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.31 (KHTML, like Gecko)".
					" Chrome/26.0.1410.64 Safari/537.31"
				)
			);
		while(1) {
			$bolBreak = false;
			
			$strContent = Rpc::call("sjtu_api", $strUrl, $arrExtra);
			$strContent = preg_replace("/\n|\r/i","", $strContent);
			$strContent = mb_convert_encoding($strContent, "UTF-8", "gb2312");
			preg_match_all($strRegPattern, $strContent, $matches);
			if( isset($matches[1][0]) &&  $matches[1][0]) {
				$arrAuthors = $matches[3];
				foreach( $arrAuthors as $k=>$strAuthor ) {
					$strDate = date("Y-m-d H:i:s", strtotime($matches[4][$k]));
					$strTitle = $matches[6][$k];
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
						"post_id" => strtr($matches[5][$k], array(
							"bbstcon,board,LoveBridge,reid,"=>"",
							".html" => ""
						)),
						"post_count" => strtr($matches[7][$k], array(
							"("=>"",
							"回复)" => ""
						))
					);
				}
				
			}
			
			//fetch start
			preg_match($strReg2nd, $strContent, $match);
			if( !isset($match[1]) ) {
				break;
			}
			$strUrl = $match[1];
			unset($matches);
			unset($match);
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
		$strGGReg = "/\[男\]|【男】|(征|求|觅).*?(mm|女|佳人)/i";
		$strMMReg = "/\[女\]|【女】|(征|求|觅).*?(gg|男|才子)/i";
		foreach($arrData as $row) {
			$row['from'] = "sjtu";
			$row['title'] = strtr($row['title'], array("○"=>"", "[代挂]"=>"", "【代挂】" => ""));
			$row['gender'] = -1;
			if(preg_match($strGGReg, $row['title'])) {
				$row['gender'] = 0;
			} elseif(preg_match($strMMReg, $row['title'])) {
				$row['gender'] = 1;
			} elseif(preg_match("/mm|美女/i", $row['title'])) {
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
		$strUrl = "/bbstcon,board,LoveBridge,reid,{$postId}.html";
		$arrExtra = array(
			'curl_opts' => array(
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.31 (KHTML, like Gecko)".
				" Chrome/26.0.1410.64 Safari/537.31"
			)
		);
		$strContent = Rpc::call( "sjtu_api", $strUrl, $arrExtra );
		
		$strContent = preg_replace("/\n|\r/i","", $strContent);
//		$strContent = mb_convert_encoding($strContent, "UTF-8", "gb2312");
		$strRegPattern = "/<font\s*class=\"title\">[^<]*<\/font>.*?".
			"<table\s*class=\"?show_border\"?[^>]+>\s*<tr>\s*<td>\s*<pre>(.*?)<\/pre>\s*<\/table>[^<]*<br>/i";
		$strRegReal = "/[0-9]{2}\:[0-9]{2}\:[0-9]{2}[^\)]*\)(.*?)(\-\-.*?|\s*)<font\s*class=[\"']c[0-9]+[\"']>/i";
		$strRegPic = "/<img\s*src=\"([^\"]+)\"[^\"]+\".*?\"[^>]*>/i";
		if( strstr( $strContent, "<br>ERROR:") ) {
			return $arrReturn;
		}
		preg_match($strRegPattern, $strContent, $matches);
		if(isset($matches[1])) {
			//http://bbs.fudan.sh.cn/bbs/con?new=1&bid=120&f=975414
			$strContent = mb_convert_encoding($matches[1], "UTF-8", "gbk");
			unset( $matches );
			preg_match( $strRegReal, $strContent, $matchReal );
			if( isset($matchReal[1]) ) {
				$arrReturn['content'] = preg_replace($strRegPic, "<img src='$1' />", $matchReal[1]);
				preg_match_all($strRegPic, $strContent, $matchPic);
				if( isset( $matchPic[1] ) && $matchPic[1] ) {
					$arrReturn['pic_list'] = $this->appendPicListPrefix( $matchPic[1] );
					$arrReturn['spot_pic'] = $arrReturn['pic_list'][0];
				}
			}
			
		}
		
		return $arrReturn;
	}
	
	private function appendPicListPrefix( $arrPicList ) {
		$arrReturn = array();
		if(!$arrPicList) {
			return;
		}
		$strPrefix = "https://bbs.sjtu.edu.cn";
		foreach($arrPicList as $strPic) {
			$arrReturn[] = $strPrefix. $strPic;
		}
		
		return $arrReturn;
	}
	
	private function checkStopWords( $strTitle ) {
		$strReg = "/yc|被暂停|发文权限|十大|撤牌|(主|陪)挂.+?号/i";
		return preg_match($strReg, $strTitle);
	}
}