<?php
/**
 * 接收参数处理
 *
 * @author zzl<598515020@qq.com>
 */
class lib_context
{
	/** 数值 */
	const T_INT = 1;

	/** 数字 */
	const T_NUMBER = 2;

	/** 单精度 */
	const T_FLOAT = 3;

	/** 双精度 */
	const T_DOUBLE = 4;

	/** 字符串 */
	const T_STRING = 5;

	/** 数组 */
	const T_ARRAY = 6;

	/** 布尔 */
	const T_BOOL = 7;

	/**
	 * Get检测
	 * @param  $key     接收变量
	 * @param  $type
	 * @param  $default
	 */
	public static function get($key, $type = null, $default = null) {
		$result = isset($_GET[$key]) ? $_GET[$key] : $default;
		return self::validate($result, $type);
	}

	/**
	 * Post检测
	 * @param  $key     接收变量
	 * @param  $type
	 * @param  $default
	 */
	public static function post($key, $type = null, $default = null) {
		$result = isset($_POST[$key]) ? $_POST[$key] : $default;
		return self::validate($reuslt, $type);
	}

	/**
	 * Request检测
	 * @param  $key     接收变量
	 * @param  $type
	 * @param  $default
	 */
	public static function request($key, $type = null, $default = null) {
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		return self::validate($result, $type);
	}

	/**
	 * 类型检测
	 * @param  $value 接收变量
	 * @param  $type
	 */
	public static function validate($value, $type = null) {
		switch (strval($type)) {
			case self::T_INT:
				return (int)$value;
			case self::T_NUMBER:
				return lib_validate::is_num($value) ? $value : '0';
			case self::T_FLOAT:
			case self::T_DOUBLE:
				return (float)$value;
			case self::T_STRING:
				return (string)$value;
			case self::T_ARRAY:
				return is_array($value) ? $value : array();
			case self::T_BOOL:
				return $value == 'false' ? false : (boolean)$value;
		}

		return $value;
	}

	/**
	 * 返回全部GET
	 */
	public static function get_all() {
		return $_GET;
	}

	/**
	 * 返回全部POST
	 */
	public static function post_all() {
		return $_POST;
	}

	/**
	 * 检测是否为POST提交
	 * @return boolean
	 */
	public static function is_post() {
		return 'post' == strtolower($_SERVER['REQUEST_METHOD']);
	}

	/**
	 * 判断是否为AJAX提交
	 * @param  boolean $exit
	 * @return boolean
	 */
	public static function is_ajax($exit = false) {
		$result = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' ? true : false;

		if ($result === false && $exit) {
			exit('Access Deny');
		}

		return $result;
	}
}
