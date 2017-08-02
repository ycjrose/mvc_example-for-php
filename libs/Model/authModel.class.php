<?php
	class authModel{//对用户信息进行核对
		private $auth = "";//管理员信息

		public function _construct(){
			if(isset($_SESSION['auth'])&&(!empty($_SESSION['auth']))){
				$this->auth = $_SESSION['auth'];
			}
		}

		public function loginsubmit(){
			if(empty($_POST['usename'])||empty($_POST['password'])){
				return false;
			}else{

				$usename = addslashes($_POST['usename']);
				$password = addslashes($_POST['password']);
				//用户验证操作->拆分到其他方法里减少单个方法代码量
				if($this->auth = $this->checkuser($usename,$password)){
					$_SESSION['auth'] = $this->auth;
					return true;
				}else{
					return false;
				}
			}
		}
		private function checkuser($usename,$password){//验证用户名密码是否一致
			$adminobj = M('admin');
			$auth = $adminobj->findOne_by_usename($usename);
			if(!empty($auth)&&$auth['password']==$password){
				return $auth;
			}else{
				return false;
			}
		}

		public function getauth(){
			return $this->auth;
		}

		public function logout(){
			unset($_SESSION['auth']);
			$this->auth = "";
		}
	}
?>