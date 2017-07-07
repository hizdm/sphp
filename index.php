<?php
/**
 * SPHP(Simple PHP Framework)
 * @author  hizdm <598515020@qq.com>
 * @copyright w3schools.wang
 * @version  2016/6/24
 */

/** 是否调试 */
error_reporting(E_ALL);

/** 加载配置文件 */
require('config/config.php');

/** 启动程序 */
require(FRAMEWORK_DIR . 'include/bootstrap.php');

/** 路由分发 */
$lib_router = new lib_router();
$lib_router->dispatch();

/** 登录及权限验证 */
$lib_router->router_rights();
$lib_router->execute_router();