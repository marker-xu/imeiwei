<?php

namespace common\consts;

/**
 * 状态返回时的常量
 *
 * Class CodeConst
 * Author: guoliuyong
 * Date: 2019-12-23 14:38
 */
class CodeMessageConst
{
    const SUCCESS               = array(200, '成功');

    // 系统级错误信息
    const INPUT_ERROR           = array(102, "输入参数错误");
    const AUTH_ERROR            = array(102, "没有权限操作");

    const LOGIN_ERROR           = array(103, "请登录后操作");

    const SERVICE_ERROR         = array(104, "系统错误，请稍后重试");
    const CLIENT_ERROR          = array(105, "系统错误，请稍后重试");
    const SYSTEM_ERROR          = array(201, "系统错误，请稍后重试");
    const NOT_FOUND_ERROR       = array(404, "访问的请求不存在");

}