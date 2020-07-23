<?php


namespace common\helpers;


class DecryptHelper
{
    /**
     * 解密凯德的base64
     * @param $encoded
     * @return int
     */
    public static function base64Decode($encoded)
    {
        $key = 'lToWfMpEHAcir_JLRdBDSkaU5hPnmOCqVZ2KXNzI4uwGx01Ys379egtQ8yF-vbj6';
        $value = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $map = [];
        for ($i = 0; $i < strlen($key); $i++) {
            $map[$key[$i]] = $value[$i];
        }
        for ($j = 0; $j < strlen($encoded); $j++) {
            $encoded[$j] = $map[$encoded[$j]];
        }
        return (int)base64_decode($encoded);
    }
}