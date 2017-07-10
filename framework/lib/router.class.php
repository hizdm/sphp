<?php
/**
 * 路由基础类
 * @author  hizdm <598515020@qq.com>
 */
class lib_router
{
	protected static $site;
	protected static $controller;
	protected static $action;
	protected static $dir;

	public function __construct() {

	}

	/** 路由分发 */
	public function dispatch() {
		self::$site = lib_context::get('site', lib_context::T_STRING, DEFAULT_SITE);
		self::$controller = lib_context::get('ctl', lib_context::T_STRING, DEFAULT_CONTROLLER);
		self::$action = lib_context::get('act', lib_context::T_STRING, DEFAULT_ACTION);

		$class_name = 'controller_' . self::$controller;
		$class_file = ROOT_DIR . self::$site . '/' .str_replace('_', '/', $class_name) . '.class.php';

		// if (!file_exists($class_file)) {
		// 	$controller_base = new frame_controller_base();
		// 	$controller_base->show_404();
		// }
		$this->_cur_obj = new $class_name();
		// if ( ! method_exists($this->_cur_obj, self::$action)) {
		// 	$controller_base = new frame_controller_base();
		// 	$controller_base->show_404();
		// }
	}

	/** 执行路由 */
	public function execute_router() {
		call_user_func_array(array($this->_cur_obj, self::$action), array());
	}

	/** 路由权限 */
	public function router_rights() {
		return true;
	}

	/** 返回当前目录 */
	public static function cur_dir() {
		return self::$dir;
	}

	/** 返回当前应用 */
	public static function cur_site() {
		return self::$site;
	}

	/** 返回当前控制器 */
	public static function cur_controller() {
		return self::$controller;
	}

	/** 返回当前方法 */
	public static function cur_action() {
		return self::$action;
	}
}