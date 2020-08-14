<?php


namespace common\helpers;


/**
 * Class IpHelper
 * @package common\helpers
 * @desc: ip hekper
 * @name: IpHelper
 * @author xucongbin
 * @date 2020/8/142:12 下午
 */
class IpHelper extends \yii\helpers\IpHelper
{
    /**
     * 获取IP
     * @return array|false|string
     */
    public static function getUserIP()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = 'unknown';
        }
        if ($pos = strpos($ip, ',')) {
            $ip = substr($ip, 0, $pos);
        }
        return $ip;
    }
}