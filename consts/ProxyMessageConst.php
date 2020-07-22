<?php

namespace common\consts;

/**
 * Class ProxyMessageConst
 * @package common\consts
 * @desc: proxy message
 * @name: ProxyMessageConst
 * @author xucongbin
 * @date 2020/6/44:26 PM
 */
class ProxyMessageConst
{
    /**
     * 发送介质，1: 邮件，2：短信，3：企微公众号，4：站内信
     * @var int
     */
    const MEDIUM_EMAIL = 1;
    const MEDIUM_SMS = 2;
    const MEDIUM_WORK_WEIXIN_OFFICIAL_ACCOUNT = 3;
    const MEDIUM_SITE_MESSAGE = 4;
}