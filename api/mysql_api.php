<?php

/*
掌握满足单例模式的必要条件
(1)私有的构造方法-为了防止在类外使用new关键字实例化对象
(2)私有的成员属性-为了防止在类外引入这个存放对象的属性
(3)私有的克隆方法-为了防止在类外通过clone成生另一个对象
(4)公有的静态方法-为了让用户进行实例化对象的操作
*/
class MySqlAPI
{
    //私有的属性
    private static $dbcon = null;
    private $host = '127.0.0.1';
    private $port = '3306';
    private $user = 'root';
    private $pwd = '123';
    private $charset = 'utf8';
    private $db = 'Timatic_DB';
    private $link;

    //私有的构造方法
    private function __construct()
    {
        //连接数据库
        $this->db_connect();
        mysqli_query($this->link, "use {$this->db}");
        //设置字符集
        mysqli_query($this->link, "set names {$this->charset}");
    }

    //连接数据库
    private function db_connect()
    {
        $this->link = mysqli_connect($this->host . ':' . $this->port, $this->user, $this->pwd);
        if (!$this->link) {
            echo "数据库连接失败<br>";
            echo "错误编码" . mysqli_errno($this->link) . "<br>";
            echo "错误信息" . mysqli_error($this->link) . "<br>";
            exit;
        }
    }

    //私有的克隆
    private function __clone()
    {
        die('clone is not allowed');
    }

    //公用的静态方法
    public static function getInstance()
    {
        self::$dbcon = new self;
        return self::$dbcon;
    }

    /**
     * 获得数据库中表的所有字段数组
     * @param string $data_base 数据库名
     * @param string $table_name 表名
     * @return array 由表中所有字段组成的数组，格式为 'filed_name'=>'filed_name'
     */
    protected function getFieldArray($data_base, $table_name)
    {
        $db = MySqlAPI::getInstance();
        $sql = "select COLUMN_NAME from information_schema.columns where table_schema='$data_base' and table_name='$table_name'";
        $res = $db->getAll($sql);
        $db->close();

        if ($res == null) {
            return [];
        }

        $arr = [];
        foreach ($res as $val) {
            $arr[$val['COLUMN_NAME']] = $val['COLUMN_NAME'];
        }

        return $arr;
    }

    //执行sql语句的方法
    public function query($sql)
    {
        $res = mysqli_query($this->link, $sql);
        if (!$res) {
            $err_code = mysqli_errno($this->link);
            $err_msg = mysqli_error($this->link);
            die("{'err_code':'$err_code', msg':'sql_excution_error', 'err_msg':'$err_msg'}");
        }
        return $res;
    }

    //获得最后一条记录id
    public function getInsertid()
    {
        return mysqli_insert_id($this->link);
    }

    /**
     * 查询某个字段
     * @param
     * @return string or int
     */
    public function getOne($sql)
    {
        $query = $this->query($sql);
        return mysqli_free_result($query);
    }

    //获取一行记录,return array 一维数组
    public function getRow($sql, $type = "assoc")
    {
        $query = $this->query($sql);
        if (!in_array($type, array("assoc", 'array', "row"))) {
            die("mysqli_query error");
        }
        $funcname = "mysqli_fetch_" . $type;
        return $funcname($query);
    }

    //获取一条记录,前置条件通过资源获取一条记录
    public function getFormSource($query, $type = "assoc")
    {
        if (!in_array($type, array("assoc", "array", "row"))) {
            die("mysqli_query error");
        }
        $funcname = "mysqli_fetch_" . $type;
        return $funcname($query);
    }

    //获取多条数据，二维数组
    public function getAll($sql)
    {
        $query = $this->query($sql);
        $list = array();
        while ($r = $this->getFormSource($query)) {
            $list[] = $r;
        }
        return $list;
    }

    /**
     * 定义添加数据的方法
     * @param string $table 表名
     * @param array $data 插入的数据，元素的格式为 ['filed_name' => 'data' ]
     * @return int 最新添加的id
     */
    public function insert($table, $data)
    {
        $key_str = implode(",", array_keys($data));
        $val_str = '';
        foreach ($data as $val) {
            $val_str .= "'$val'" . ',';
        }
        $val_str = trim($val_str, ',');

        $sql = "insert into `$table` ($key_str) values ($val_str)";
        $this->query($sql);

        return $this->getInsertid();
    }

    /**
     * 删除一条数据方法
     * @param string $table 表名
     * @param array $where 条件
     * @return int 受影响的行数
     */
    public function deleteOne($table, $where)
    {
        $sql = "delete from $table where $where";
        $this->query($sql);
        //返回受影响的行数
        return mysqli_affected_rows($this->link);
    }

    /**
     * 删除多条数据方法
     * @param string $table 表名
     * @param array $where 条件
     * @return int 受影响的行数
     */
    public function deleteAll($table, $where)
    {
        if (is_array($where)) {
            foreach ($where as $key => $val) {
                if (is_array($val)) {
                    $condition = $key . ' in (' . implode(',', $val) . ')';
                } else {
                    $condition = $key . '=' . $val;
                }
            }
        } else {
            $condition = $where;
        }
        $sql = "delete from $table where $condition";
        $this->query($sql);
        //返回受影响的行数
        return mysqli_affected_rows($this->link);
    }

    /**
     * [修改操作description]
     * @param string $table 表名
     * @param array $data 数据
     * @param array $where 条件
     * @return int 返回受影响的行数
     */
    public function update($table, $data, $where)
    {
        //遍历数组，得到每一个字段和字段的值
        $str = '';
        foreach ($data as $key => $v) {
            $str .= "$key='$v',";
        }
        $str = rtrim($str, ',');

        $sql = "update $table set $str where $where";
        $this->query($sql);

        return mysqli_affected_rows($this->link);
    }

    /**
     * 关闭数据库
     * @return bool 是否成功关闭
     */
    public function close()
    {
        mysqli_close($this->link);
    }
}
