<?php

namespace common\consts;

/**
 * Class BindConst
 * @package common\consts
 * @desc: 绑定状态
 * @name: BindConst
 * @date 2019/12/271:50 PM
 */
class BindConst
{
    const APPLYING  = 1; // 申请中
    const BINDING   = 2; // 绑定
    const REJECT    = 3; // 绑定拒绝
    const UNBIND    = 4; // 解绑
    const DELETE    = 5; // 解绑
}