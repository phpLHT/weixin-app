<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'   => 'mysql', // 数据库类型
//    'DB_HOST'   => 'sqld-gz.bcehost.com', // 服务器地址
     'DB_HOST'   => 'localhost',
//    'DB_NAME'   => 'ymphUHovqgjnnodbGIen', // 数据库名
    'DB_NAME'   => 'agent',
//    'DB_USER'   => 'c4c33315c0494ec9b35e9f3e71b08f63', // 用户名
    'DB_USER'   => 'root',
//    'DB_PWD'    => '93bfc40c1cfe4e7d8945fc38c7a430bb', // 密码
    'DB_PWD'    => '123456', // 密码
//    'DB_PORT'   => 4050, // 端口
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'a_', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    'URL_CASE_INSENSITIVE'  =>  true,  //url不区分大小写
    'URL_MODEL'=>3, //url模式 兼容; 
    'URL_HTML_SUFFIX'       =>  '',
//    'READ_DATA_MAP'=>true,  //开启
    
    'DEFAULT_MODULE'       =>  'Admin' ,// 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index' // 默认操作名称
);