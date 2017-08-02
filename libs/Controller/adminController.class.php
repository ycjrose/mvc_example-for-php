<?php
	class adminController{
		public $auth = "";

		public function _construct(){
			//判断当前是否登录-->auth的构造方法处理
			//如果不是登录页，而且没有登录，跳转到登录页
			session_start();
			$authobj = M('auth');
			$this->auth = $authobj->getauth();
			if((PC::$method!='login')&&empty($this->auth)){
				$this->showmessage('请登录后再操作','admin.php?controller=admin&method=login');
			}
		}
		//显示主页
		public function index(){
			$newsobj = M('news');
			$newsnum = $newsobj->count();
			VIEW::assign(array('newsnum' => $newsnum));
			VIEW::display('admin/index.html');
		}

		public function login(){
			if($_POST){
				//进行登录处理
				//登录处理业务逻辑分在admin auth
				//admin同表名模型：从数据库取出用户信息
				//auth模型：对用户信息进行核对
				//-->把一系列的登录处理拆分到新的方法里面去
				$this->checklogin();

			}else{
				//显示登陆界面
				VIEW::display('admin/login.html');
			}
			
		}
		private function checklogin(){
			$authobj = M('auth');
			if ($authobj->loginsubmit()) {
				$this->showmessage('登陆成功','admin.php?controller=admin&method=index');
			}else{
				$this->showmessage('登录失败','admin.php?controller=admin&method=login');
			}
		}
		//添加新闻
		public function newsadd(){
			//判断是否有POST数据
			if(empty($_POST)){//显示修改添加界面
				//读取旧信息,若有$_GET['id'],说明是修改新闻，取出旧信息
				if(isset($_GET['id'])){
					$data = M('news')->getnewsinfo($_GET['id']);
				}else{
					$data = array();
				}
				VIEW::assign(array('data' => $data));
				VIEW::display('admin/newsadd.html');
			}else{
				//进入添加修改处理程序
				$this->newssubmit();
			}
		} 
		//提交新闻处理方法拆分出来
		private function newssubmit(){
			$sm = M('news')->newssubmit($_POST);
			if($sm==0){
				$this->showmessage('操作失败','admin.php?controller=admin&method=newsadd&id='.$_POST['id']);
			}
			if($sm==1){
				$this->showmessage('添加成功','admin.php?controller=admin&method=newslist');
			}
			if($sm==2){
				$this->showmessage('修改成功','admin.php?controller=admin&method=newslist');
			}
		}
		//管理文章
		public function newslist(){
			$data = M('news')->findAll_orderby_dateline();
			VIEW::assign(array('data' => $data));
			VIEW::display('admin/newslist.html');
		}
		//删除文章
		public function newsdel(){
			if($_GET['id']){
				M('news')->del_by_id($_GET['id']);
				$this->showmessage('删除成功','admin.php?controller=admin&method=newslist');
			}
		}
		//退出登录
		public function logout(){
			$authobj = M('auth');
			$authobj->logout();
			$this->showmessage('退出成功','admin.php?controller=admin&method=login');
		}
		//用来弹出信息并跳转的函数
		private function showmessage($info,$url){
			echo "<script>alert('$info');window.location.href='$url'</script>";
			exit;
		}
	}
?>