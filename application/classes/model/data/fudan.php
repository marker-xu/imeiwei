<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Fudan extends Model {
	
	private $isSingle=false;
	
	private $arrDateBetween;
	
	private $arrParams = array();
	
	private $arrData = array();
	
	public function __construct( ) {
		$this->arrDateBetween = array(
			"start" => date("Y-m-d\TH:i:s", strtotime("-1 day")),
			"end" =>  date("Y-m-d\TH:i:s")
		);
	}
	
	public function setDateBetween( $strStartDate, $strEndDate=NULL ) {
		if(!$strStartDate) {
			return;
		}
		$strStartDate = date("Y-m-d\TH:i:s", strtotime($strStartDate));
		if( !$strEndDate ) {
			$strEndDate = date("Y-m-d\TH:i:s", strtotime($strStartDate)+3600 );
		} else {
			$strEndDate = date("Y-m-d\TH:i:s", strtotime( $strEndDate)  );
		}
		$this->arrDateBetween = array(
			"start" => $strStartDate,
			"end" => $strEndDate
		);
	}
	
	public function isSingle( $bolSingle ) {
		$this->isSingle = $bolSingle;
	}
	
	public function setParams( $arrParams ) {
		$this->arrParams = array_merge($this->arrParams, (array)$arrParams);
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
		$arrParams["bid"] = $this->isSingle ? 120 : 70;
		
		$strReg1st = "/<po\s*m=\'\+\'\s*owner='([^']+)'\s*time=\s*'([^']+)'\s*id='([^']+)'>\s*(Re\:)?\s*([^<]+)\s*<\/po>/i";
		$strReg2nd = "/<brd\s*title=.*?start=['\"]([0-9]+)['\"]\s*bid=.*?\/>/i";
		
		while(1) {
			$bolBreak = false;
			$strUrl = "/bbs/doc?".http_build_query( $arrParams );
			$strContent = Rpc::call("fudan_api", $strUrl);
			
			$strContent = preg_replace("/\n|\r/i","", $strContent);
			$strContent = mb_convert_encoding($strContent, "UTF-8", "gb2312");
//			$strContent = iconv("GBK", "UTF-8", iconv("gb18030", "gbk", $strContent));
			preg_match_all($strReg1st, $strContent, $matches);
			if( isset($matches[1][0]) &&  $matches[1][0]) {
				$arrAuthors = $matches[1];
				foreach( $arrAuthors as $k=>$strAuthor ) {
					$strDate = $matches[2][$k];
					if(stristr($matches[4][$k], "Re") || $this->checkStopWords($matches[5][$k]) ) {
						continue;
					}
					if( !$this->checkDateValid($strDate) ) {
						$bolBreak = true;
						continue;
					}
					$arrReturn[] = array(
						"title" => $matches[5][$k], 
						"date" => $strDate, 
						"author" => $strAuthor,
						"post_id" => $matches[3][$k],
					);
				}
				
			}
			
			//fetch start
			preg_match($strReg2nd, $strContent, $match);
			if( !isset($match[1]) ) {
				break;
			}
			$intStart = $match[1]-20;
			unset($matches);
			unset($match);
			$arrParams['start'] = $intStart;
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
		$strGGReg = "/征.*mm|求.*mm/i";
		$strMMReg = "/征.*gg|求.*gg/i";
		foreach($arrData as $row) {
			$row['date'] = strtr($row['date'], array("T"=>" "));
			$row['from'] = $this->isSingle ? "fudan_single" : "fudan_mb";
			$row['gender'] = -1;
			if(preg_match($strGGReg, $row['title'])) {
				$row['gender'] = 0;
			} elseif(preg_match($strMMReg, $row['title'])) {
				$row['gender'] = 1;
			} elseif(preg_match("/mm/i", $row['title'])) {
				$row['gender'] = 1;
			} elseif(preg_match("/gg/i", $row['title'])) {
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
		$arrParams = array(
			"new" => 1,
			"bid" => $this->isSingle ? 120 : 70,
			"f" => $postId
		);
		$strUrl = "/bbs/con?" . http_build_query( $arrParams );
		$strContent = Rpc::call( "fudan_api", $strUrl );
//		echo $strContent;
		$strContent = preg_replace("/\n|\r/i","", $strContent);
		$strContent = mb_convert_encoding($strContent, "UTF-8", "gb2312");
		$strRegPattern = "/<pa\s*m=\'t\'>(.*)<\/pa>\s*<pa\s*m=\'s\'>/i";
		$strRegPic = "/<a\s*i='i'\s*href='([^']+)'\s*\/>/i";
		if( strstr( $strContent, "class=\"errorbox\"") ) {
			return $arrReturn;
		}
		preg_match($strRegPattern, $strContent, $matches);
		if(isset($matches[1])) {
			//http://bbs.fudan.sh.cn/bbs/con?new=1&bid=120&f=975414
			$strContent = $matches[1];
			unset( $matches );
			$arrReturn['content'] = preg_replace($strRegPic, "<img src='$1' />", $strContent);
			preg_match_all($strRegPic, $strContent, $matchPic);
			if( isset( $matchPic[1] ) ) {
				$arrReturn['pic_list'] = $matchPic[1];
				$arrReturn['spot_pic'] = isset( $arrReturn['pic_list'][0] ) ? $arrReturn['pic_list'][0] :"";
			}
			
		}
		
		return $arrReturn;
	}
	
	private function checkStopWords( $strTitle ) {
		$strReg = "/yc|被暂停|发文权限|十大|撤牌|(主|陪)挂.+?号/i";
		return preg_match($strReg, $strTitle);
	}
}