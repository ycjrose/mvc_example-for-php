<?php
	$currentdir = dirname(__FILE__);//获取该文件当前所在文件夹路径
	include_once($currentdir.'/include.list.php');//引入路径文件
	foreach($path as $value){
		//引入所有模板所需文件
		include_once($currentdir.'/'.$value);
	}
	class PC{
		public static $controller;
		public static $method;
		private static $config;
		private static function init_db(){
			//连接数据库
			DB::init('mysql',self::$config['dbconfig']);
		}
		private static function init_view(){
			//连接视图库
			VIEW::init('Smarty',self::$config['viewconfig']);
		}
		private static function init_controller(){
			//获取控制器
			self::$controller = isset($_GET['controller'])?addslashes($_GET['controller']):'index';
		}
		private static function init_method(){
			//获取方法
			self::$method = isset($_GET['method'])?addslashes($_GET['method']):'index';
		}
		public static function run($config){
			//外部入口函数，模板引擎开动
			self::$config = $config;
			self::init_db();
			self::init_view();
			self::init_controller();
			self::init_method();
			C(self::$controller,self::$method);
		}
	}
?>