<?php


namespace common\helpers;

use ClickHouseDB\Client;
use Yii;

/**
 * Class ClickHouseHelper
 * @package common\helpers
 * @desc: clickhouse
 * @name: ClickHouseHelper
 * @author xucongbin
 * @date 2019/11/138:26 PM
 */
class ClickHouseHelper
{
    /**
     * @var ClickHouseHelper
     */
    private static $instance;

    /**
     *
     * @return ClickHouseHelper
     */
    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * @return Client
     */
    public function getClickClient()
    {
        $config = Yii::$app->params['clickHouse'];
        $db = new Client($config);
        $db->database("cpc_satellite");
        $db->setTimeout(5);       // 10 seconds
        $db->setConnectTimeOut(5); // 5 seconds
        return $db;
    }
}