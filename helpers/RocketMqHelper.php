<?php

namespace common\helpers;

use MQ\MQClient;
use MQ\MQProducer;
use MQ\MQConsumer;
use MQ\MQTransProducer;
use Yii;

/**
 * Class RocketMqHelper
 * @package common\helpers
 * @desc: rocket mq
 * @name: RocketMqHelper
 * @author xucongbin
 * @date 2019/12/282:27 PM
 */
class RocketMqHelper
{

    /**
     * @var NsqHelper
     */
    protected static $instance;

    /**
     * @var MQClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $instanceId;


    /**
     * @return RocketMqHelper
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
        $this->config       = Yii::$app->params['rocket_mq'];
        $this->instanceId   = $this->config['instance_id'];
        $this->client       = new MQClient($this->config['endpoint'], $this->config['access_key'], $this->config['secret_key']);
    }

    /**
     * @param string $topic
     * @return MQProducer
     */
    public function getProducer($topic)
    {
        return $this->client->getProducer($this->instanceId, $topic);
    }

    /**
     * @param string $topic
     * @param string $consumer
     * @param string $messageTag
     * @return MQConsumer
     */
    public function getConsumer($topic, $consumer, $messageTag = null)
    {
        return $this->client->getConsumer($this->instanceId, $topic, $consumer, $messageTag);
    }

    /**
     * @param $topic
     * @param $groupId
     * @return MQTransProducer
     */
    public function getTransProducer($topic, $groupId)
    {
        return $this->client->getTransProducer($this->instanceId, $topic, $groupId);
    }
}