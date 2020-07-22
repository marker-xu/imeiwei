<?php

namespace common\consts;

/**
 * 公用常量
 *
 * Class CommonConst
 * Author: guoliuyong
 * Date: 2019-12-23 14:37
 */
class CommonConst
{
    /**
     * 记录状态相关，0：有效，1：删除
     */
    const ACTIVE    = 0;
    const DELETED   = 1;

    /**
     * bm那边设置请求涞源
     */
    const BM_SERVICE_FROM = 'AM';

    /**
     * 审核相关，1：审核中，2：审核通过，3: 审核拒绝
     */
    const AUDIT_ING    = 1;
    const AUDIT_PASS   = 2;
    const AUDIT_REFUSE = 3;

    /**
     * 分页相关
     */
    const PAGE_SIZE = 20;

    /**
     * 列表获取全部
     */
    const ALL = -1;

    /**
     * 角色名称
     */
    const ROLE_ADMIN          = 'admin';            // 超级管理员
    const ROLE_OPERATOR       = 'operator';         // 运营
    const ROLE_GUEST          = 'guest';            // 访客
    const ROLE_TEST           = 'test';             // 测试角色
    const ROLE_MEDIA_CREATOR  = 'media_creator';    // 媒体创建人
    const ROLE_MEDIA_TRANSFER = 'media_transfer';   // 媒体对接人
    const ROLE_HUDONG_ADMIN   = 'hudong_admin';   // 互动管理员
}