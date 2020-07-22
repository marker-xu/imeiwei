<?php

namespace common\consts;

/**
 * Class ConfigConst
 * Author: guoliuyong
 * Date: 2020-04-23 11:54
 */
class ConfigConst
{
    /**
     * 配置类型 0:全局配置, 1:dsp配置,2:互动配置，3:样式实验，4:功能实验
     * @var int
     */
    const TYPE_GLOBAL   = 0;
    const TYPE_DSP      = 1;
    const TYPE_HD       = 2;
    const TYPE_STYLE    = 3;
    const TYPE_FUNCTION = 4;

    /**
     * 表名 0:默认 1:media 2:adslot
     * @var int
     */
    const TABLE_DEFAULT = 0;
    const TABLE_MEDIA   = 1;
    const TABLE_ADSLOT  = 2;

}