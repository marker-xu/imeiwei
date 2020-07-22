<?php

namespace common\consts;

/**
 * 操作日志常量
 *
 * Class OperationLogConst
 * Author: guoliuyong
 * Date: 2020-04-14 14:07
 */
class OperationLogConst
{
    /**
     * 模块类型
     * 1 账户列表 11 账户申请
     * 2 角色相关
     * 3 权限相关
     * 4 媒体列表    41 媒体结构 42 媒体集 43 媒体组
     * 5 广告位列表  51 广告位审核    52 专家模式 53 竞价模式 54 全局配置平台
     * 6 实验配置    61 样式和功能配置 62 dsp配置
     * 7 DSP渠道配置 71 DSP广告位配置
     * 8 互动广告
     * 91 行业黑名单(地域维度)-广告位  92 行业黑名单(地域维度)-媒体 93 素材等级(地域维度)-广告位    94 素材等级(地域维度)-媒体    95 行业黑名单(全量)-广告位  96 行业黑名单(全量)-媒体
     * 101 样式
     */
    const TYPE_ACCOUNT_LIST   = 1;
    const TYPE_ACCOUNT_APPLY  = 11;

    const TYPE_ROLE     = 2;
    const TYPE_PERM     = 3;

    const TYPE_MEDIA    = 4;
    const TYPE_MEDIA_STRUCTURE  = 41;
    const TYPE_MEDIA_SET        = 42;
    const TYPE_MEDIA_GROUP      = 43;

    const TYPE_ADSLOT         = 5;
    const TYPE_ADSLOT_REVIEW  = 51;
    const TYPE_ADSLOT_EXPERT  = 52;
    const TYPE_ADSLOT_BIDDING = 53;
    const TYPE_ADSLOT_QU_CONFIG = 54;

    const TYPE_CONFIG      = 6;
    const TYPE_CONFIG_STYLE_OR_FUNCTION   = 61;
    const TYPE_CONFIG_DSP   = 62;

    const TYPE_DSP_CONFIG      = 7;
    const TYPE_DSP_ADSLOT      = 71;

    const TYPE_HD       = 8;

    const TYPE_SHIELD_ADSLOT_REGION         = 91;
    const TYPE_SHIELD_MEDIA_REGION          = 92;
    const TYPE_SHIELD_ADSLOT_CITY           = 93;
    const TYPE_SHIELD_MEDIA_CITY            = 94;
    const TYPE_SHIELD_ADSLOT_BLACK_CATEGORY = 95;
    const TYPE_SHIELD_MEDIA_BLACK_CATEGORY  = 96;

    const TYPE_STYLE_ADD    = 101;

    /**
     * 记录的操作类型 1 新增  2 修改  3 删除
     */
    const RECORD_TYPE_ADD    = 1;
    const RECORD_TYPE_EDIT   = 2;
    const RECORD_TYPE_DELETE = 3;

    /**
     * 主ID来源 1 传参  2 table中获取
     */
    const SOURCE_REQUEST           = 1;
    const SOURCE_TABLE             = 2;


}