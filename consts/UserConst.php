<?php

namespace common\consts;

/**
 * 用户级常量
 *
 * Class UserConst
 * Author: guoliuyong
 * Date: 2020-03-02 11:23
 */
class UserConst
{
    /**
     * 是否是超管 0 不是  1 是
     */
    const IS_ADMIN_TRUE     = 1;
    const IS_ADMIN_FALSE    = 0;

    /**
     * 是否是渠道用户 0 不是  1 是
     */
    const IS_CHANNEL_TRUE   = 1;
    const IS_CHANNEL_FALSE  = 0;

    /**
     * 用户类型 0 普通用户  1 管理员  2 渠道用户 3 商务用户 4 商务管理员
     */
    const ACC_TYPE_COMMON   = 0;
    const ACC_TYPE_CHANNEL  = 1;
    const ACC_TYPE_ADMIN    = 2;
    const ACC_TYPE_BD       = 3;
    const ACC_TYPE_BD_ADMIN = 4;

    /**
     * 用户类型label
     */
    const ACC_TYPE = [
        self::ACC_TYPE_COMMON    => "普通用户",
        self::ACC_TYPE_ADMIN     => "管理员",
        self::ACC_TYPE_CHANNEL   => "渠道用户",
        self::ACC_TYPE_BD        => "商务用户",
        self::ACC_TYPE_BD_ADMIN  => "商务管理员",
    ];

    /**
     * 来源 0 未设置  1 QTT  2 HZ 3 CPC 4 HB
     */
    const SOURCE_UNSET  = 0;
    const SOURCE_QTT    = 1;
    const SOURCE_HZ     = 2;
    const SOURCE_CPC    = 3;
    const SOURCE_HB     = 4;

    /**
     * 来源label
     */
    const SOURCE = [
        self::SOURCE_UNSET  => "未设置",
        self::SOURCE_QTT    => "QTT",
        self::SOURCE_HZ     => "HZ",
        self::SOURCE_CPC    => "CPC",
        self::SOURCE_HB     => "HB",
    ];
}