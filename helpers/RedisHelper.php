<?php

namespace common\helpers;

use QttLib\Yii\Tracing\RedisConnection;
use Yii;

class RedisHelper
{
    /**
     * 从redis里面获取缓存，缓存不存在的时候设置先执行闭包函数获取数据再设置缓存最后返回结果
     *
     * @param string $cacheKey 缓存key
     * @param \Closure|mixed $funcOrValue 待执行的闭包函数或值
     * @param int $ttl 缓存过期时间，单位秒
     *
     * @return string
     * @throws \Exception
     */
    public static function remember(string $cacheKey, $funcOrValue, int $ttl = 0)
    {
        if (!$cacheKey || !$funcOrValue) {
            throw new \Exception('RedisHelpers::remember 参数错误!');
        }

        $cache = Yii::$app->redis;
        if ($cache->exists($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $value = is_callable($funcOrValue) ? $funcOrValue() : $funcOrValue;
        if ($ttl > 0) {
            $cache->setex($cacheKey, $ttl, $value); //设置$cacheKey对应字符串$value，并且设置$cacheKey在给定的$ttl时间之后超时过期
        } else {
            $cache->set($cacheKey, $value);
        }

        return $value;
    }

    /**
     * @return RedisConnection
     */
    public static function getRedis()
    {
        return Yii::$app->redis;
    }
}
