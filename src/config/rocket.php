<?php

return [
    'global' => [
        'baseurl' => 'http://xxxxxxx.com', // 面板地址
        'defaultProxy' => 'select' // clash默认策略组名称
    ],
    'android' => [ //安卓相关功能控制
        'bootstrap' => [ // 启动图控制
            'show' => false, // 启动图开关
            'image' => 'https://timgsa.baidu.com/', // 启动图片url
            'url' => 'http://baidu.com' // 启动图点击后的跳转地址，可为空（即不跳转）
        ],

        'notice' => [ // 弹窗公告
            'show' => false, // 公告开关
            'title' => '我是公告', // 公告标题
            'content' => '1.请尝试切换手机网或连接wifi<br>2.请切换线路，推荐使用台湾<br>3.请重启手机或路由器', // 公告内容，支持html
            'url' => 'http://baidu.com' // 公告点击后的跳转地址，可为空（即不跳转）
        ],

        'update' => [ //更新控制
            'version' => 335, //最新版本号
            'desc' => '1.更新了一套全新的UI<br>2.稳定性优化<br>3.加快联网速度', // 更新内容，支持html
            'download' => 'http://baidu.com' // 更新包下载地址
        ],

    ],

    'common' => [ // Mac + Win 相关功能控制

        'notice' => [ // 弹窗公告
            'show' => false, // 公告开关
            'title' => '我是公告', // 公告标题
            'content' => '1.请尝试切换手机网或连接wifi<br>2.请切换线路，推荐使用台湾<br>3.请重启手机或路由器', // 公告内容，支持html
        ],

        'update' => [ //更新控制
            'version' => 335, //最新版本号
            'desc' => '1.更新了一套全新的UI<br>2.稳定性优化<br>3.加快联网速度', // 更新内容，支持html
            'pc' => 'http://baidu.com', // PC更新包下载地址
            'mac' => 'http://baidu.com' // MAC更新包下载地址
        ],

        'preference' => [ // 偏好设置

            'bootstrap' => //控制弹出小窗口的尺寸
                [
                    'width' => 400, //宽度
                    'height' => 600 //高度
                ],
            'nav' => //控制加速页面的右侧导航,至多4个
                [
                    [
                        'desc' => '购买套餐',
                        'color' => '#1890ff',
                        'link' => '/#/plan'
                    ],
                    [
                        'desc' => '邀请好友',
                        'color' => '#1890ff',
                        'link' => '/#/invite'
                    ]
                ]
        ]
    ]
];
