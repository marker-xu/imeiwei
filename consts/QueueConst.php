<?php

namespace common\consts;

/**
 * 队列常量
 *
 * Class QueueConst
 * @package common\consts
 * @desc: resque
 * @name: QueueConst
 * @author xucongbin
 * @date 2019/12/25:15 PM
 */
class QueueConst
{
    /**
     * 1:默认，2:执行，3:失败，4:完成
     * @var int
     */
    const STATUS_DEFAULT = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_FAILURE = 3;
    const STATUS_COMPLETED = 4;
}