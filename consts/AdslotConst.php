<?php

namespace common\consts;

/**
 * Class AdslotConst
 * @package common\consts
 * @desc: 媒体的一些常量
 * @name: AdslotConst
 * @author xucongbin
 * @date 2019/12/271:50 PM
 */
class AdslotConst
{
    /**
     * 广告位类型，
     * 1列表页信息流2，详情页信息流，3互动广告，4开屏广告,5横幅，6、视频 7 激励广告
     * @var int
     */
    const AD_TYPE_LIST = 1;
    const AD_TYPE_DETAIL = 2;
    const AD_TYPE_HD = 3;
    const AD_TYPE_OPEN = 4;
    const AD_TYPE_BANNER = 5;
    const AD_TYPE_VIDEO = 6;
    const AD_TYPE_INCENTIVE = 7;

    /**
     * 广告创意类型
     * 1图文，2图片，3组图，4、视频，6、文字链 7、互动广告 8、开屏广告，9、横幅 10 激励广告位
     * 11竖版视频，12激励视频，15激励视频测试，16试玩广告， 17福利广告
     * @var int
     */
    const IDEA_TYPE_LIST = 1;
    const IDEA_TYPE_IMAGE= 2;
    const IDEA_TYPE_PHOTOS = 3;
    const IDEA_TYPE_VIDEO = 4;
    const IDEA_TYPE_WORD_CHAIN = 6;
    const IDEA_TYPE_HD = 7;
    const IDEA_TYPE_OPEN = 8;
    const IDEA_TYPE_BANNER = 9;
    const IDEA_TYPE_INCENTIVE = 10;
    const IDEA_TYPE_VERTICAL_VIDEO = 11;
    const IDEA_TYPE_INCENTIVE_VIDEO = 12;
    const IDEA_TYPE_INCENTIVE_VIDEO_TEST = 15;
    const IDEA_TYPE_TRIAL_GAME = 16;
    const IDEA_TYPE_WELFARE = 17;

    /**
     * 对接方式，1 api,2 js sdk,3android sdk,4ios sdk
     * @var int
     */
    const ACCESS_TYPE_API = 1;
    const ACCESS_TYPE_JS = 2;
    const ACCESS_TYPE_ANDROID = 3;
    const ACCESS_TYPE_IOS = 4;

    /**
     * 审核状态字段 :0待审核；1：通过；2：未通过 3 永不再审 4 下线
     * @var int
     */
    const AUDIT_INIT = 0;
    const AUDIT_PASS = 1;
    const AUDIT_DENY = 2;
    const AUDIT_DENY_FOREVER = 3;
    const AUDIT_OFFLINE = 4;

    /**
     * 结算方式 : 0 未设置  1 原始结算，2 按比例分成结算，3 cpm结算，4 cpc结算 5 不结算
     * @var int
     */
    const SETTLEMENT_TYPE_INIT      = 0;
    const SETTLEMENT_TYPE_ORIGINAL  = 1;
    const SETTLEMENT_TYPE_RATE      = 2;
    const SETTLEMENT_TYPE_CPM       = 3;
    const SETTLEMENT_TYPE_CPC       = 4;
    const SETTLEMENT_TYPE_NOT       = 5;

    /**
     * 互动的默认值
     * @var int
     */
    const HD_GAME_TIME = 8;

    /**
     * 广告位name字段的分隔符，中文-
     */
    const NAME_DELIMITER = '-';

    /**
     * 广告位名字的含义  0:媒体名称  1:系统名称   2:一级结构   3:二级结构   4:自定义名称
     */
    const NAME_POSITION_0 = 0;
    const NAME_POSITION_1 = 1;
    const NAME_POSITION_2 = 2;
    const NAME_POSITION_3 = 3;
    const NAME_POSITION_4 = 4;

    /**
     *
     */
    const HD_SETTLEMENT_TYPE_INNER = 1;
    const HD_SETTLEMENT_TYPE_OTHER = 2;

    /**
     * 城市等级， L1: 一线，L2：新一线，L3：二线， L4：三线， L5：四线， L6：五线
     * @var int
     */
    const CITY_LEVEL_1 = 1;
    const CITY_LEVEL_2 = 2;
    const CITY_LEVEL_3 = 3;
    const CITY_LEVEL_4 = 4;
    const CITY_LEVEL_5 = 5;
    const CITY_LEVEL_6 = 6;

    /**
     * 素材等级 L0: 卓越，L1: 优秀，L2：次优，L3：一般，L4：其它
     * @var int
     */
    const MATERIAL_LEVEL_BEST = 0;
    const MATERIAL_LEVEL_BETTER = 1;
    const MATERIAL_LEVEL_GOOD = 2;
    const MATERIAL_LEVEL_NORMAL = 3;
    const MATERIAL_LEVEL_OTHER = 4;
}