<?php
return array(
    //'配置项'=>'配置值'

    //'配置项'=>'配置值'
    'URL_MODEL' => 1,  //url路由模式
    'URL_HTML_SUFFIX' => 'html|shtml|xml',  // URL伪静态
    'SHOW_PAGE_TRACE' => false,//开启调试模式
    'URL_CASE_INSENSITIVE' => false,   // 默认false 表示URL区分大小写 true则表示不区分大小写
//        'HTML_CACHE_ON'     =>    true, // 开启静态缓存
//        'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
//        'HTML_FILE_SUFFIX'  =>    '.html', // 设置静态缓存文件后缀
//        'HTML_CACHE_RULES'  =>     array(   '静态地址'      =>     '静态规则', ),


//模板URL常量配置
    'CSS_URL' => __ROOT__ . '/APP/Public/home/css/', //前台css路径
    'JS_URL' => __ROOT__ . '/APP/Public/home/js/',//前台js路径
    'IMG_URL' => __ROOT__ . '/APP/Public/home/img/',//前台images路径
    'ADMIN_CSS_URL' => __ROOT__ . '/APP/Public/admin/css/', //后台css路径
    'ADMIN_JS_URL' => __ROOT__ . '/APP/Public/admin/js/',//后台js路径
    'ADMIN_IMG_URL' => __ROOT__ . '/APP/Public/admin/img/',//后台images路径
    //jquery地址
    'JQUERY_URL' => __ROOT__ . '/APP/Public/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js',
    //编辑器urlx常量
    'UE_URL' => __ROOT__ . '/APP/Public/ueditor/',
    'SMALL_URL' => __ROOT__ . '/APP/Public/upload/images/',
    'UE_UPLOAD_ARR' => __ROOT__ . '/APP/Public/ueditor/php/action_list.php',

    //验证码地址
    'VERIFY_URL' => __ROOT__ . '/admin.php/Login/verifyImg',


    //链接数据
    'DB_TYPE' => 'mysql',//数据库类型
    'DB_HOST' => 'localhost',//数据库服务器地址
    'DB_NAME' => 'boke',//数据库名称
    'DB_USER' => 'root',//数据库用户名
    'DB_PWD' => '12315Smm',//数据库连接密码
    'DB_PORT' => '3306',//数据库端口号
    'DB_PREFIX' => 'bk_',//数据库表前缀

);