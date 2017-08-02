<?php
	class newsModel{
		public $_table = 'news';

		function count(){
			$sql = 'select count(*) from '.$this->_table;
			return DB::findResult($sql);
		}

		function getnewsinfo($id){
			if(empty($id)){
				return array();
			}else{
				$id = intval($id);
				$sql = 'select * from '.$this->_table.' where id = '.$id;
				return DB::findOne($sql);
			}
		}

		function findAll_orderby_dateline(){
			$sql = 'select * from '.$this->_table.' order by dateline desc';
			return DB::findAll($sql);
		}

		function newssubmit($data){
			extract($data);
			if(empty($title)||empty($content)){
				return 0;
			}
			$title = addslashes($title);
			$content = addslashes($content);
			$author = addslashes($author);
			$fromS = addslashes($fromS);
			$data = array(
					'title' => $title,
					'content' => $content,
					'author' => $author,
					'fromS' => $fromS
				);
			if($_POST['id']!=""){
				DB::update($this->_table,$data,'id='.$id);
				return 2;
			}else{
				DB::insert($this->_table,$data);
				return 1;
			}
		}

		function del_by_id($id){
			$id = intval($id);
			return DB::del($this->_table,'id='.$id);
		}

		function get_news_list(){
 			$data = $this->findAll_orderby_dateline();
			foreach ($data as $key => $news) {
				$data[$key]['content'] = mb_substr(strip_tags($data[$key]['content']),0,200);
			}
			return $data;
		}
	}
?>