<?php
	class mysql{
		/**
		* 报错函数
		* @param string $error 
		**/
		function err($error){
			die("对不起，您的操作有误，原因是：".$error);
		}

		/**
		* 连接数据库
		* @param string $dbhost 主机名
		* @param string $dbuser 用户名
		* @param string $dbpsw  密码
		* @param string $dbname 数据库名
		* @param string $dbcharset 字符集/编码
		* @return bool 连接是否成功
		**/
		function connect($config){
			extract($config); //把数组的键名当成变量名来使用
			if(!($con = mysql_connect($dbhost,$dbuser,$dbpsw))){
				$this->err(mysql_error());//连接mysql不成功报错

			}
			if(!mysql_select_db($dbname,$con)){
				$this->err(mysql_error());//选择数据库失败报错
			}
			mysql_query("set names ".$dbcharset);//设置连接编码
		}
		/**
		*执行SQL语句
		* @param string $sql
		* @return bool 执行成功返回资源，失败输出错误
		**/
		function query($sql){
			if($query = mysql_query($sql)){
				return $query;//返回sql执行结果
			}else{
				$this->err($sql."<br/>".mysql_error());
			}
		}
		/**
		* 取出从数据表中获取的所有结果保存在数组中
		* @param source $query sql语句通过mysql_query()执行出来的资源
		* @return array 返回列表数组
		**/
		function findAll($query){
			while($rs = mysql_fetch_array($query,MYSQL_ASSOC)){//mysql_fetch_array()函数每次取一行的值，MYSQL_ASSOC参数返回关联数组
				$list[] = $rs;
			}
			return isset($list)?$list:"";
		}
		/**
		* 单条数据
		* @param source $query
		* @return array 返回一行信息的数组
		**/
		function findOne($query){
			$rs = mysql_fetch_array($query,MYSQL_ASSOC);
			return $rs;
		}
		/**
		* 获取指定行指定字段的值
		* @param source $query
		* @param int $row 指定行
		* @param string $field 偏移值或者字段名
		* @return string/false 返回字段值或false 
		**/
		function findResult($query,$row = 0,$field = 0){
			$rs = mysql_result($query,$row,$field);
			if (!$rs) {
				return '未知错误';
			}
			return $rs;
		}
		/**
		* 增加数据
		* @param string $table 表名
		* @param array $arr 添加数组（包含字段和值的一维数组）
		* 
		**/
		function insert($table,$arr){
			//insert 表名(多个字段) values(多个值);
			foreach($arr as $key => $value){
				$value = mysql_real_escape_string($value);
				$keyArr[] = "`".$key."`";//把$arr数组中的键名保存到$key[]数组中
				$valueArr[] = "'".$value."'";//把$arr数组中的值保存到values[]数组中

			}
			$keys = implode(",", $keyArr);//implode函数是把数组组合成字符串，第一个参数是每个值之间以什么符号相连
			$values = implode(",", $valueArr);
			$sql = "insert ".$table."(".$keys.") values(".$values.")";
			$this->query($sql);
			return mysql_insert_id();//返回刚才插入操作的id
		}
		/**
		* 更新数据
		* @param string $table
		* @param array $arr 修改数组（包括字段和值的一维数组）
		* @param string where 条件
		**/
		function update($table,$arr,$where){
			//update 表名 set 字段=字段值 where 条件
			foreach($arr as $key => $value){
				$value = mysql_real_escape_string($value);
				$keyAndValueArr[] = "`".$key."`='".$value."'"; 
			}
			$keyAndValues = implode(",", $keyAndValueArr);
			$sql = "update ".$table." set ".$keyAndValues." where ".$where;
			$this->query($sql);
		}
		/**
		* 删除数据
		* @param string $table
		* @param string $where
		**/
		function del($table,$where){
			//delete from 表名 where 条件
			$sql = "delete from ".$table." where ".$where;
			$this->query($sql);
		}

	}
?>





