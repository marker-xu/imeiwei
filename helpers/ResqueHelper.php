<?php

namespace common\helpers;

use common\library\exception\ClientException;
use common\models\ResqueQueueModel;
use console\models\resque\jobs\DelayJob;
use console\models\resque\jobs\DispatchSiteMessageJob;
use console\models\resque\jobs\DownloadJob;
use console\models\resque\jobs\MyJob;
use console\models\resque\scheduler\Scheduler;
use console\models\resque\scheduler\InvalidTimestampException;
use Resque;
use Resque_Redis;
use Resque_Job_Status;

use Yii;

/**
 * Class ResqueHelper
 * @package common\library
 * @desc: resque 助手类
 * @name: ResqueHelper
 * @author xucongbin
 * @date 2019/5/293:48 PM
 */
class ResqueHelper
{
    /**
     * @var string
     */
    protected $defaultQueue;

    /**
     * @var ResqueHelper
     */
    protected static $instance;

    /**
     * @var array
     */
    protected static $topicClassMap = [
        'DelayJob' => DelayJob::class,
        'MyJob' => MyJob::class,
        'DownloadJob' => DownloadJob::class,
        'DispatchSiteMessage' => DispatchSiteMessageJob::class,
    ];

    /**
     * @return ResqueHelper
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
     * ResqueHelper constructor.
     */
    protected function __construct()
    {
        $config = Yii::$app->params['resque'];
        $dsn = $config['redis'];
        Resque::setBackend($dsn);
        Resque_Redis::prefix($config['prefix']);
        $this->defaultQueue = $config['queue'];
    }

    /**
     * @param string $topic
     * @param mixed $message
     * @return boolean|string
     * @throws ClientException
     */
    public function sendMessage($topic, $message)
    {
        $class = $this->buildClass($topic);
        $args = $this->buildArgs($message);

        $res = Resque::enqueue($this->defaultQueue, $class, $args, true);
        Yii::info('send to resque, topic-' . $topic . ', message-' . json_encode($message) .
            ', res-' . intval($res),
            __METHOD__);
        ResqueQueueModel::addJob($res, $args, $this->defaultQueue, $topic);
        return $res;
    }

    /**
     *
     * @param int $delayedSeconds
     * @param string $topic
     * @param mixed $message
     * @return bool|string
     * @throws ClientException
     * @throws InvalidTimestampException
     * @throws \Resque_Exception
     */
    public function sendDelayedMessage($delayedSeconds, $topic, $message)
    {
        if ($delayedSeconds < 1)
        {
            self::sendMessage($topic, $message);
        }
        $class = $this->buildClass($topic);
        $args = $this->buildArgs($message);
        $res = Scheduler::enqueueIn($delayedSeconds, $this->defaultQueue, $class, $args);
        Yii::info('send to resque, topic-' . $topic . ', message-' . json_encode($message) .
            ', res-' . intval($res), __METHOD__);
        return $res;
    }

    /**
     * @param string $jobId
     * @return int
     */
    public function trackStatus($jobId)
    {
        $status = new Resque_Job_Status($jobId);
        return $status->get();
    }

    /**
     * @param mixed $message
     * @return array
     */
    private function buildArgs($message)
    {
        if (is_array($message))
        {
            $args = $message;
        }
        else
        {
            $args = [
                'message' => $message,
            ];
        }
        return $args;
    }

    /**
     *
     * @param string $topic
     * @return string
     * @throws ClientException
     */
    private function buildClass($topic)
    {
        if (!isset(self::$topicClassMap[$topic]))
        {
            throw new ClientException('topic未配置');
        }
        $class = self::$topicClassMap[$topic];
        return $class;
    }
}