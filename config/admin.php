<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

// admin配置 http://skyselang.gitee.io/yyladmindoc/
return [
    // token方式：header、param；token名称；前后端必须一致
    'token_type' => env('admin.token_type', 'header'),
    'token_name' => env('admin.token_name', 'AdminToken'),

    // 系统超管用户ID（所有权限）
    'super_ids' => env('admin.super_ids', [1, 2]),

    // 系统超管用户是否隐藏
    'super_hide' => env('admin.super_hide', true),

    // 菜单免登url（无需登录）
    'menu_is_unlogin' => [
        'admin/system.Login/setting',
        'admin/system.Login/captcha',
        'admin/system.Login/login',
    ],

    // 菜单免权url（无需权限）
    'menu_is_unauth' => [
        'admin/system.Index/index',
        'admin/system.Index/notice',
        'admin/system.Notice/info',
        'admin/system.Login/logout',
        'admin/system.UserCenter/info',
    ],

    // 菜单免限url（不限速率）
    'menu_is_unrate' => [
        'admin/file.File/add',
        'admin/file.File/list',
    ],

    // 日志记录请求参数排除字段（敏感、内容多等信息）
    'log_param_without' => [
        'password',
        'password_old',
        'password_new',
        'password_confirm',
        'content',
        'images',
        'videos',
        'audios',
        'words',
        'annexs',
        'others',
    ],
];
