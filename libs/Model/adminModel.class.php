<?php
	class adminModel{//从数据库存取数据

		public $_table = 'admin';//定义表名
		//通过用户名取用户信息函数
		public function findOne_by_usename($usename){
			$sql = 'select * from '.$this->_table.' where usename="'.$usename.'"';
			return DB::findOne($sql);
		}
		//用户密码核对-->auth
	}
?>