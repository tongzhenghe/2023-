<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

// 行为验证码配置：https://gitee.com/anji-plus/captcha
return [
    'font_file' => '',   //自定义字体包路径，不填使用默认值
    //文字验证码
    'click_world' => [
        'backgrounds' => [],
        'word_num' => 3, //文字数量（2-5）
    ],
    //滑动验证码
    'block_puzzle' => [
        'backgrounds' => [],   //背景图片路径，不填使用默认值
        'templates'   => [],   //模板图
        'offset'      => 10,   //容错偏移量
    ],
    //水印
    'watermark' => [
        'fontsize' => 12,
        'color'    => '#ffffff',
        'text'     => ''
    ],
    'cache' => [
        'constructor' => [\think\facade\Cache::class, 'instance']
    ]
];
