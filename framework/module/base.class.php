<?php
/**
 * 模型基类
 * @author hizdm <598515020@qq.com>
 */
class frame_module_base
{
	/** @var null 数据库实例对象 */
	public $db = null;

    /** 表名 */
	public $table ='';

	/** 创建数据库实例对象 */
	public function __construct($table = '') {
        if ( ! empty($table)) {
        	$this->table = $table;
        }
		$this->db = lib_mysql::getinstance();
	}

	/**
	 * 获取单行数据
	 * @param  array|string $condition 查询条件
	 * @param  string       $field     查询字段
	 * @param  string       $order     排列字段
	 * @return array
	 */
	public function fetch_row($condition = '', $field = '*', $order = '', $type = 'r') {
        $condition = $this->_format_condition($condition);

        $condition = !empty($condition) ? " WHERE {$condition} " : '';
        $order = !empty($order) ? ' ORDER BY ' . $order : '';
        $sql   = "SELECT {$field} FROM `{$this->table}` {$condition} {$order} LIMIT 1";

        return $this->db->fetch_row($sql, $type);
    }

    /**
     * 获取多行数据
     * @param  string $condition 查询条件
     * @param  string $order     排列字段
     * @param  string $limit     查询范围
     * @param  string $group     分组字段
     * @return array
     */
    public function fetch_all($condition = '', $order = '', $limit = '', $group = '', $type = 'r') {
        $condition = $this->format_condition($condition);

        $condition = !empty($condition) ? " WHERE {$condition} " : '';
        $order = !empty($order) ? " ORDER BY {$order} " : '';
        $limit = !empty($limit) ? " LIMIT {$limit} " : '';
        $group = !empty($group) ? " GROUP BY {$group} " : '';
        $sql = "SELECT * FROM `{$this->table}` {$condition} {$group} {$order} {$limit}";

        return $this->db->fetch_all($sql, $type);
    }

    /**
     * 更新数据
     * @param  array|string $data      要更新的数据
     * @param  array|string $condition 更新条件
     * @return
     */
    public function update($data, $condition, $type = 'w') {
        if (!is_array($data) || count($data) == 0 || empty($condition)) {
        	return false;
        }
        $set_info = array();
        foreach ($data as $key => $value) {
            $set_info[] = '`' . $key . '` = ' . "'$value'";
        }
        $set_str = implode(',', $set_info);
        $condition = $this->format_condition($condition);
        $sql = "UPDATE `{$this->table}` SET {$set_str} WHERE {$condition}";
        return $this->db->exec($sql, $type);
    }

    /**
     * 获取查询数量
     * @param  string|array $condition 查询条件
     * @return int
     */
    public function fetch_count($condition = '', $type = 'r') {
        $condition = $this->format_condition($condition);

        $condition = !empty($condition) ? " WHERE {$condition} " : '';
        $sql = "SELECT COUNT(*) AS count FROM `{$this->table}` {$condition}";
        $res = $this->db->fetch_row($sql, $type);

        return $res['count'];
    }

    /**
     * 执行SQL
     */
    public function exec_sql($sql) {
        return $this->db->exec($sql);
    }

    /**
     * 格式化条件
     * @param array|string $data
     */
    private function _format_condition($data) {
        $condition = '';
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $condition .= "AND `{$key}`='{$value}' ";
            }

            $condition = ltrim($condition, 'AND');
        } else {
            $condition = $data;
        }

        return $condition;
    }
}