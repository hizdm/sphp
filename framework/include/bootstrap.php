<?php
/**
 * SPHP程序启动
 * @author hizdm <598515020@qq.com>
 * @copyright http://w3schools.wang
 */
class load
{
	public static function loadClass($classname) {
		$path = explode('_', $classname);
		switch ($path['0']) {
			case 'frame':
				unset($path['0']);
				$file = FRAMEWORK_DIR . implode($path, '/') . '.class.php';
				break;
			case 'lib':
				$file = FRAMEWORK_DIR . implode($path, '/') . '.class.php';
				break;
			case 'config':
				$file = CONFIG_DIR . $path['1'] . '.class.php';;
				break;
			default:
				$file = ROOT_DIR . lib_router::cur_site() . '/' . implode($path, '/') . '.class.php';
				break;
		}

		if (!empty($file)) {
			require_once "$file";
		}
	}
}

spl_autoload_register(array('load', 'loadClass'));