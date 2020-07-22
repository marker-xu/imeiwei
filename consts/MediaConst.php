<?php

namespace common\consts;

/**
 * Class MediaConst
 * @package common\consts
 * @desc: 媒体的一些常量
 * @name: MediaConst
 * @author xucongbin
 * @date 2019/12/271:50 PM
 */
class MediaConst
{
    /**
     * 媒体和用户关系
     * 关系类型，1: 创建者，2: 对接人，3:关注
     */
    const RELATION_CREATOR = 1;
    const RELATION_DOCKING = 2;
    const RELATION_FOLLOW = 3;

    /**
     *
     */
    const MEDIA_STATUS_ONLINE = 0;
    const MEDIA_STATUS_OFFLINE = 1;
    const MEDIA_STATUS_AUDIT = 2;
    const MEDIA_STATUS_DELETE = 3;

    /**
     * 媒体客户端类型
     * 0: 全量 1: app，2:h5, 3:ios
     * @var int
     */
    const TYPE_ALL = 0;
    const TYPE_APP = 1;
    const TYPE_H5  = 2;
    const TYPE_IOS = 3;

    /**
     * 0:申请中，1：审核通过， 2: 拒绝
     *
     * @var int
     */
    const APPLY_STATUS_DEFAULT = 0;
    const APPLY_STATUS_PASS = 1;
    const APPLY_STATUS_DENY = 2;

    /**
     * media_structure表中的level  分类级别 1 是一级结构    2 代表二级结构
     *
     * @var int
     */
    const STRUCTURE_LEVEL_ONE = 1;
    const STRUCTURE_LEVEL_TWO = 2;

    /**
     * 统一个媒体下，一级或二级结构的最大数量
     */
    const STRUCTURE_MAX_NUM = 999;

    /**
     * 媒体组是否优选
     */
    const GROUP_PREFERRED = 1;
    const GROUP_COMMON = 0;
}