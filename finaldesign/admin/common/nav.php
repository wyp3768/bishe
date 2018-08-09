<?php
	$leftnav = [
    'nav'=>[
        'name'=>'导航管理',
        'icon'=>'&#xe65f;',
        'purview'=>[
            'show'=>'查看',
            'create'=>'创建',
            'update'=>'修改',
        ],
        'menu'=>[
            [
                'name'=>'导航列表',
                'url' =>'./nav_list.php',
            ]            
        ]
    ],
    'goods'=>[
        'name'=>'产品管理',
        'icon'=>'&#xe62d;',
        'purview'=>[
            'show'=>'查看',
            'create'=>'创建',
            'update'=>'修改',
        ],
        'menu'=>[
            [
                'name'=>'产品列表',
                'url' =>'./goods-list.php'
            ],
            [
            	'name'=>'系列分类',
            	'url' =>'./category_series.php'
            ],
            [
                'name'=>'大小分类',
                'url' =>'./category_size.php'
            ],
            [
                'name'=>'形状分类',
                'url' =>'./category_shape.php'
            ],
        ]
    ],
    'banner'=>[
        'name'=>'轮播管理',
        'icon'=>'&#xe634;',
        'purview'=>[
            'show'=>'查看',
            'create'=>'创建',
            'update'=>'修改',
        ],
        'menu'=>[
            [
                'name'=>'轮播列表',
                'url' =>'./banner-list.php'
            ],
            [
                'name'=>'小轮播列表',
                'url' =>'./banner-little-list.php'
            ],
            [
                'name'=>'广告列表',
                'url' =>'./ad-list.php'
            ],
        ]
    ],
    'order'=>[
        'name'=>'订单管理',
        'icon'=>'&#xe642;',
        'purview'=>[
            'show'=>'查看',
            'create'=>'创建',
            'update'=>'修改',
        ],
        'menu'=>[
            [
                'name'=>'订单列表',
                'url' =>'./order.php'
            ]
        ]
    ],
    // 'comment'=>[
    //     'name'=>'评论管理',
    //     'icon'=>'&#xe606;',
    //     'purview'=>[
    //         'show'=>'查看',
    //         'create'=>'创建',
    //         'update'=>'修改',
    //     ],
    //     'menu'=>[
    //         [
    //             'name'=>'评论列表',
    //             'url' =>'./comment-list.php'
    //         ],
    //     ]
    // ],
    'user'=>[
        'name'=>'用户管理',
        'icon'=>'&#xe612;',
        'purview'=>[
            'show'=>'查看',
            'create'=>'创建',
            'update'=>'修改',
        ],
        'menu'=>[
            [
                'name'=>'用户列表',
                'url' =>'./user-list.php'
            ],
            // [
            //     'name'=>'购物车列表',
            //     'url' =>'./user-shopcart.php'
            // ],
        ]
    ],
    'administrator'=>[
        'name'=>'管理员管理',
        'icon'=>'&#xe613;',
        'purview'=>[
            'show'=>'查看',
            'create'=>'创建',
            'update'=>'修改',
        ],
        'menu'=>[
            [
                'name'=>'管理员列表',
                'url' =>'./admin-list.php',
            ],
            [
            	'name'=>'角色列表',
            	'url' =>'./admin-role.php',
            ]
        ]
    ],
    // 'system'=>[
    //     'name'=>'系统管理',
    //     'icon'=>'&#xe614;',
    //     'purview'=>[
    //         'show'=>'查看',
    //         'create'=>'创建',
    //         'update'=>'修改',
    //     ],
    //     'menu'=>[
    //         [
    //             'name'=>'系统设置',
    //             'url' =>'./sys-set.html'
    //         ],
    //         [
    //         	'name'=>'屏蔽词',
    //         	'url' =>'./sys-shield.html'
    //         ],
    //         [
    //         	'name'=>'友情链接',
    //         	'url' =>'./sys-link.html'
    //         ]
    //     ]
    // ],

];
?>