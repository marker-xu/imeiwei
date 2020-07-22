<?php

namespace common\consts;

/**
 * Class ProxyAppConst
 * @package common\consts
 * @desc: app的业务常量
 * @name: ProxyAppConst
 * @author xucongbin
 * @date 2020/5/282:00 PM
 */
class ProxyAppConst
{
    /**
     * 应用ID， 0：空，7: 赤兔，8：鲸鱼
     * @var int
     */
    const APP_NONE = 0;
    const APP_CRM = 1;
    const APP_AM = 2;
    const APP_UNION = 3;
    const APP_SATELLITE = 4;
    const APP_DMP = 5;
    const APP_LABS = 6;
    const APP_CHITU = 7;
    const APP_WHALE = 8;
    const APP_ADV = 9;
    const APP_SEARCH = 10;
    const APP_AUDIT = 11;

    /**
     * 发送状态，0: 初始， 1: 发送中，2:发送成功，3:发送失败
     * @var int
     */
    const SITE_MESSAGE_SEND_STATUS_INIT = 0;
    const SITE_MESSAGE_SEND_STATUS_DOING = 1;
    const SITE_MESSAGE_SEND_STATUS_SUCCESS = 2;
    const SITE_MESSAGE_SEND_STATUS_FAILURE = 3;
}