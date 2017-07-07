<?php
/**
 * 数据库配置
 *
 * @author zzl<598515020@qq.com>
 */
class config_data
{
	/**
	 * Mysql数据库配置
	 */
	public static function db_mysql($target = 'default') {
		$config = array(
			'default' => array(
				'r' => array(
					'host' => '127.0.0.1',
					'port' => '3306',
					'user' => 'root',
					'pass' => 'mysql',
					'name' => 'w3c'
				),
				'w' => array(
					'host' => '127.0.0.1',
					'port' => '3306',
					'user' => 'root',
					'pass' => 'mysql',
					'name' => 'w3c'
				),
				'encoding'     => 'utf8',
				'table_prefix' => 'w3c'
			)
		);

		// $config = array(
		// 	'default' => array(
		// 		'r' => array(
		// 			'host' => '211.149.206.74',
		// 			'port' => '3306',
		// 			'user' => 'root',
		// 			'pass' => 'makepolozzl',
		// 			'name' => 'typecho'
		// 		),
		// 		'w' => array(
		// 			'host' => '211.149.206.74',
		// 			'port' => '3306',
		// 			'user' => 'root',
		// 			'pass' => 'makepolozzl',
		// 			'name' => 'typecho'
		// 		),
		// 		'encoding'     => 'utf8',
		// 		'table_prefix' => 'typecho'
		// 	)
		// );

		return $config['default'];
	}
}