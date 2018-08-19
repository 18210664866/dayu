<?php

return array(
    //'配置项'=>'配置值'
    // 数据库常用配置
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'localhost', // 数据库服务器地址
    'DB_NAME' => 'dayu', // 数据库名
    'DB_USER' => 'root', // 数据库用户名
    'DB_PWD' => 'root', // 数据库密码
    'DB_PORT' => 3306, // 数据库端口
    'DB_PREFIX' => 'dayu_', // 数据库表前缀（因为漫游的原因，数据库表前缀必须写在本文件）
    'DB_CHARSET' => 'utf8', // 数据库编码
    // URl
    'URL_CASE_INSENSITIVE' => true,
    'URL_MODEL' => 2,
    'URL_HTML_SUFFIX' => 'html',
    'URL_ROUTER_ON' => true, // 是否开启URL路由
    // Cookie
    'COOKIE_PREFIX' => 'odr',
    'APP_GROUP_LIST' => 'Home,Admin', // 项目分组设定
    //自定义路径常量的配置项
    'TMPL_PARSE_STRING' => array(
        '__HOME__' => '/Public/Home',
        '__HOMECSS__' => '/Public/home/css',
        '__HOMEJS__' => '/Public/home/js',
        '__HOMEIMG__' => '/Public/home/images',
    ),
    
    //微信接口
    'token' => 'zh664866',
    'appid' => 'wx393862cef02d0d3e',
    'appsecret' => '0fafa0813a156e113dee0f890d89c94b',
    //模板消息
    'MODEL_ID' => '313CH5kslcALs76B82VacmN3MQ-cQnHR7e7CtdynNJQ',
);
