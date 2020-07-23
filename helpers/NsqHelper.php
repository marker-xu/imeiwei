<?php

namespace common\helpers;
use common\consts\CommonConst;
use Yii;

/**
 * Class NsqHelper
 * @package common\library
 * @desc: nsq 助手类
 * @name: NsqHelper
 * @author xucongbin
 * @date 2019/5/293:48 PM
 */
class NsqHelper
{

    /**
     * 操作类型
     * @var string
     */
    const OPERATION_ALL = 'all';
    const OPERATION_ADD = 'add';
    const OPERATION_REMOVE = 'delete';

    /**
     * @var NsqHelper
     */
    protected static $instance;

    /**
     * @var Nsq
     */
    protected $nsqClient;

    /**
     * @return NsqHelper
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
     * NsqHelper constructor.
     */
    protected function __construct()
    {
        $nsqServer = Yii::$app->params['nsq_server'];
        $nsq = new \Nsq();
        $nsq->connectNsqd($nsqServer);
        $this->nsqClient = $nsq;
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        if ($this->nsqClient !== null)
        {
            $this->nsqClient->closeNsqdConnection();
        }
    }
}