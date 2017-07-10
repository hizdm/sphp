<?php
/**
 * 框架基础 Controller
 * @author  zzl <598515020@qq.com>
 */
class frame_controller_base
{
	public $view;
	public function __construct() {
		$this->_init();
	}

	public function __isset($name) {
		return isset($this->$name);
	}

	public function __call($name, $arguments) {
		if (!$this->__isset($name)) {
			echo '此操作不存在！';
			exit();
		}
	}

	/**
	 * 框架Controller初始化
	 */
	protected function _init() {
		/** Smarty设置 */
		require_once(SMARTY_DIR . 'Smarty.class.php');
		$this->view = new Smarty();

		if ( ! is_dir(VIEW_COMPILE_DIR)) {
			lib_utils::mkdir(VIEW_COMPILE_DIR, 0777);
		}
		if ( ! is_dir(VIEW_CACHE_DIR)) {
			lib_utils::mkdir(VIEW_CACHE_DIR, 0777);
		}

		$this->view->left_delimiter = "<!--{";
		$this->view->right_delimiter = "}-->";
		$this->view->compile_dir = VIEW_COMPILE_DIR;
		$this->view->cache_dir = VIEW_CACHE_DIR;
	}

	/**
	 * 封装框架的 assign 方法
	 * @param  string $tpl_var   模板变量
	 * @param  mixed  $value     变量
	 * @param  string $xss_clean 过滤标志
	 * @return
	 */
	public function assign($tpl_var, $value = null, $xss_clean = 'ALL_HTML_TAGS') {
		$this->view->assign($tpl_var, $value, $xss_clean);
	}

	/**
	 * 封装框架的 display 方法
	 * @param  string $template_name 模板名称
	 * @return
	 */
	public function display($template_name) {
		$this->view->display(ROOT_DIR . DEFAULT_SITE . '/' . TEMPLATE_DIR . $template_name . TEMPLATE_EXT);
	}

	/**
	 * 公用页面输出
	 * @param  string  $template_name 模板名称
	 * @param  integer $type          类型
	 * @return
	 */
	public function show($template_name, $type = 404) {
		switch ($type) {
			case 404:
				header("HTTP/1.1 404 Not Found");
				break;
			default:
				// No Logic
				break;
		}

		$this->display($template_name);
	}
}