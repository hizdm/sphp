<?php
/**
 * 项目模型基类
 */
class module_base extends frame_module_base
{
	public function __construct() {
		parent::__construct();
	}

	// 测试方法
	public function index() {
	    return new frame_module_base('w3c_contents');
	}
}