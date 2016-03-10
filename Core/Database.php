<?php

namespace Core {

	class Database {
		private $db_host = "localhost";
		private $db_user = "test";
		private $db_pass = "";
		private $db_name = "test";

		var $con = false;
		var $result = array();
		var $myQuery = "";
		var $nums = "";
		function __construct() {
			print_r(
				array(
					"namespace" => __NAMESPACE__,
					"class" => __CLASS__
				)
			);
			if(!$this->con){
				$myconn = @mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
				if($myconn){
					$select_db = @mysqli_select_db($this->db_name, $myconn);
					if($select_db){
						mysqli_query("SET character_set_results='utf8'");
						mysqli_query("SET character_set_client='utf8'");
						mysqli_query("SET character_set_connection='utf8'");
						mysqli_query("SET AUTOCOMMIT=0");
						$this->con = true;
						return true;
					}else{
						array_push($this->result, mysqli_error($myconn));
						return false;
					}
				}else{
					array_push($this->result, mysqli_connect_error());
					return false;
				}
			}else{
				return true;
			}
		}

		public function query($sql) {
			$this->result = array();
			$this->nums = 0;
			$query = @mysqli_query($sql);
			if($query){
				$this->nums = @mysqli_num_rows($query);
				for($i = 0; $i < $this->nums; $i++){
					$r = @mysqli_fetch_array($query);
					$key = array_keys($r);
					$count = count($key);
					for($x = 0; $x < $count; $x++){
						if(!is_int($key[$x])){
							$this->result[$i][$key[$x]] = $r[$key[$x]];
						}
					}
				}
			}
			return ($this->result);
		}

		public function select($table, $rows = '*', $where = null, $order = null, $limit = null) {
			$q = 'SELECT '.$rows.' FROM '.$table;
			if($where != null){
				$q .= ' WHERE '.$where;
			}
			if($order != null){
				$q .= ' ORDER BY '.$order;
			}
			if($limit != null){
				$q .= ' LIMIT '.$limit;
			}
			return ($this->query($q));
		}

		public function insert($table, $params){
			if (empty($params)) return -2;
			@mysqli_query('START TRANSACTION');
			$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('","', $params) . '")';
			//$this->myQuery = $sql;
			if(@mysqli_query($sql)){
				$last_id = @mysqli_insert_id();
				@mysqli_query('COMMIT');
				return $last_id;
			}
			else{
				array_push($this->result, mysqli_error());
				@mysqli_query('ROLLBACK');
				return -1;
			}
		}

		public function multiInsert($table, $fields, $params){
			print_r($params);
			if (empty($params) || !is_array($params)) return -2;
			$cnt = count($params[0]);

			foreach($params as $k => $v) {
				if (!is_array($v) || count($v) !== $cnt) return -3;
			}

			// транспонируем массив
			array_unshift($params, null);
			$params = call_user_func_array("array_map", $params);

			// складываем значения в вид (1,11,111),(2,22,222)
			$arr = array();
			foreach($params as $k => $v) {
				$arr[] = '("' . implode('","', $v) . '")';
			}


			@mysqli_query('START TRANSACTION');
			$sql='INSERT INTO `'.$table.'` (`'.implode('`,`',$fields).'`) VALUES'.implode(',', $arr);
			print_r($sql);


			if(@mysqli_query($sql)){
				$last_id = @mysqli_insert_id();
				@mysqli_query('COMMIT');
				return $last_id;
			}
			else{
				array_push($this->result, mysqli_error());
				@mysqli_query('ROLLBACK');
				return -1;
			}
		}

		// Function to update row in database
		public function update($table, $params=array(), $where){
			@mysqli_query('START TRANSACTION');
			$args=array();
			foreach($params as $field=>$value) {
				$args[]=$field.'="'.$value.'"';
			}
			$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
			if(@mysqli_query($sql)){
				return mysqli_affected_rows();
				@mysqli_query('COMMIT');
			}else{
				array_push($this->result, mysqli_error());
				@mysqli_query('ROLLBACK');
				return -1;
			}
		}
	}

}?>