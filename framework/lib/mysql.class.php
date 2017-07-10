<?php
/**
 * Mysql基础类
 * @author hizdm <598515020@qq.com>
 */
class lib_mysql
{
	private $_r = null;
	private $_w = null;
	private $_debug = false;
	private $_config = array();
	private $_character_set = 'utf8';
    private $_config_target = 'default';

    static private $_instance = null;

	private function __construct() {
		$this->init_config();
	}

	/** 获取实例 */
	static public function getinstance() {
		if (self::$_instance instanceof self) {
			return self::$_instance;
		}

		self::$_instance = new self();
		return self::$_instance;
	}

	/**
	 * 查询单条记录
	 */
	public function fetch_row($sql, $type = 'r') {
		$this->_stmtement = $this->query($sql, $type);
		if ($this->_stmtement) {
		    return $this->_stmtement->fetch(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * 查询多条记录
	 */
	public function fetch_all($sql, $type = 'r') {
		$this->_stmtement = $this->query($sql, $type);
        if ($this->_stmtement) {
            return $this->_stmtement->fetchAll(PDO::FETCH_ASSOC);
        }
	}

	/**
	 * 特殊SQL查询
	 */
	public function exec($sql, $type = 'w') {
		$instance = '_' . $type;
		if (!$this->$instance) {
			$this->connect($type);
		}

	    $this->ping($type);
	    $result = $this->$instance->exec($sql);

	    if (FALSE === $result) {
	        die('Mysql error');
	    }

	    return $result;
	}

	/**
	 * 执行SQL
	 */
	public function query($sql, $type = 'r') {
		$instance = '_' . $type;
		if (!$this->$instance) {
			$this->connect($type);
		}
		$this->ping($type);

		return $this->$instance->query($sql);
	}

	/**
	 * 连接数据库
	 */
	public function connect($type = 'r') {
		$conn = new PDO($this->_config[$type]['dsn'], $this->_config[$type]['user'], $this->_config[$type]['pass']);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if ( ! empty($this->_character_set)) {
			$conn->exec("SET NAMES {$this->_character_set}");
		}

		$instance = '_' . $type;

		return $this->$instance = $conn;
	}

	/**
	 * PDO ping
	 * @param $type
	 * @return bool
	 */
	public function ping($type) {
		$instance = '_' . $type;
		$status = $this->$instance->getAttribute(PDO::ATTR_SERVER_INFO);
		/* 连接超时和丢失连接的时候重新连 */
		if (strpos($status, 'gone away') || strpos($status, 'Lost connection')) {
			$this->close($type);
			$this->connect($type);
		}
	}

	/**
     * 销毁某个数据库连接实例
     * @param String $type r|w
     */
    public function close($type = 'r') {
    	$conn = '_' . $type;
        unset($this->$conn);
    }

	/**
	 * 初始化配置
	 */
	public function init_config() {
		$config = config_db::db_mysql($this->_config_target);

		if (!is_array($config) || !isset($config['r']['host']) || !isset($config['r']['port']) || !isset($config['r']['name']) || !isset($config['r']['user']) || !isset($config['r']['pass'])) {
			die('Mysql-read Config Error!');
		}
		$this->_config['r']['dsn'] = "mysql:host={$config['r']['host']};port={$config['r']['port']};dbname={$config['r']['name']}";
		$this->_config['r']['user'] = $config['r']['user'];
		$this->_config['r']['pass'] = $config['r']['pass'];

		$config['w'] = isset($config['w']) ? $config['w'] : $config['r'];
	    if (!isset($config['w']['host']) || !isset($config['w']['port']) || !isset($config['w']['name']) || !isset($config['w']['user']) || !isset($config['w']['pass'])) {
	        die('Mysql-write Config Error!');
	    }

	    $this->_config['w']['dsn'] = "mysql:host={$config['w']['host']};port={$config['w']['port']};dbname={$config['w']['name']}";
	    $this->_config['w']['user'] = $config['w']['user'];
	    $this->_config['w']['pass'] = $config['w']['pass'];

		/** 设置字符集 */
		if (isset($config['encoding'])) {
			$this->_character_set = $config['encoding'];
		}
	}
}