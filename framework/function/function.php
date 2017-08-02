<?php
	function C($name,$method){
		require_once("libs/Controller/".$name."Controller.class.php");
		$Controller = $name."Controller";
		$obj = new $Controller();
		$obj->$method();
	}
	
	function M($name){
		require_once('libs/Model/'.$name.'Model.class.php');
		$Model = $name.'Model';
		$obj = new $Model();
		return $obj;
	}

	function V($name){
		require_once('libs/View/'.$name.'View.class.php');
		$View = $name.'View';
		$obj = new $View();
		return $obj;
	}
?>