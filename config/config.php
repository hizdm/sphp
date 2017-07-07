<?php
/**
 * SPHP框架基础配置
 * @author  zzl <598515020@qq.com>
 */

/** 设置时区 */
ini_set('date.timezone', 'Asia/Shanghai');

/** 根目录 */
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/');

/** 框架目录 */
define('FRAMEWORK_DIR', ROOT_DIR . 'framework/');

/** 配置目录 */
define('CONFIG_DIR', ROOT_DIR . 'config/');

/** 模板目录 */
define('TEMPLATE_DIR', 'templates/');

/** 模板后缀 */
define('TEMPLATE_EXT', '.html');

/** Smarty目录 */
define('SMARTY_DIR', FRAMEWORK_DIR . 'third/smarty-2.6.30/libs/');
/** 可写临时缓存目录 */

/** Smarty编译目录 */
define('VIEW_COMPILE_DIR', ROOT_DIR . '_templates_c');

/** Smarty缓存目录 */
define('VIEW_CACHE_DIR', ROOT_DIR . '_templates_cache');

/** 默认项目 */
define('DEFAULT_SITE', 'default');

/** 默认控制器 */
define('DEFAULT_CONTROLLER', 'index');

/** 默认方法 */
define('DEFAULT_ACTION', 'index');