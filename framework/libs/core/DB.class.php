<?php
	class DB {
		public static $db;

		public static function init($dbtype,$config){
			self::$db = new $dbtype;
			self::$db->connect($config);
		}

		public static function query($sql){
			return self::$db->query($sql);
		}

		public static function findAll($sql){
			$query = self::$db->query($sql);
			return self::$db->findAll($query);
		}

		public static function findOne($sql){
			$query = self::$db->query($sql);
			return self::$db->findOne($query);
		}

		public static function findResult($sql,$row = 0,$field = 0){
			$query = self::$db->query($sql);
			return self::$db->findResult($query,$row,$field);
		}

		public static function insert($table,$arr){
			self::$db->insert($table,$arr);
		}

		public static function update($table,$arr,$where){
			self::$db->update($table,$arr,$where);
		}

		public static function del($table,$where){
			self::$db->del($table,$where);
		}
		
	}
?>