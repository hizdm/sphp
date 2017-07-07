<?php
/**
 * 默认项目default DEMO
 */
class controller_index extends controller_base
{
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Index方法
	 */
	public function index() {
		// $module_base_obj = new module_base();

		// $b = $module_base_obj->index()->fetch_row('cid = 101');

		// echo '<pre>';
		// print_r($b);
		// echo '</pre>';

		$this->assign('text', 'Hello, Simple PHP!');
		$this->display('index');
	}
}