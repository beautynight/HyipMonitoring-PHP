<?php

namespace Core {
	use \SplString;
	use \mysqli;

	class Database {
		private $db_host = 'localhost';
		private $db_user = 'test';
		private $db_pass = '';
		private $db_name = 'test';

		private $mysqli;
		private $query = "";
		private $con = false;
		private $result;
		private $nums = "";

		function __construct() {
			$this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			if($this->mysqli && !@mysqli_connect_errno()){
				$this->mysqli->set_charset("utf8");
				$this->mysqli->autocommit(false);
				$this->query("SET collation_connection = utf8_general_ci;")->send();
				return true;
			}else{
				array_push($this->result, $this->mysqli->connect_error);
				return false;
			}
		}

		public function query($sql) {
			$this->query .= $sql;
			return $this;
		}

		public function send() {
			$this->result = $this->mysqli->query($this->query);
			$this->query = '';
			return $this;
		}

		public function getResult() {
			$this->nums = 0;
			if($this->result){
				$this->nums = $this->mysqli->affected_rows;
				for($i = 0; $i < $this->nums; $i++){
					$r = @mysql_fetch_array($query);
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

		public function sendQuery($sql) {
			$this->result = array();
			$this->nums = 0;
			$query = @mysql_query($sql);
			if($query){
				$this->nums = @mysql_num_rows($query);
				for($i = 0; $i < $this->nums; $i++){
					$r = @mysql_fetch_array($query);
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
			@mysql_query('START TRANSACTION');
			$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('","', $params) . '")';
			//$this->myQuery = $sql;
			if(@mysql_query($sql)){
				$last_id = @mysql_insert_id();
				@mysql_query('COMMIT');
				return $last_id;
			}
			else{
				array_push($this->result, mysql_error());
				@mysql_query('ROLLBACK');
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


			@mysql_query('START TRANSACTION');
			$sql='INSERT INTO `'.$table.'` (`'.implode('`,`',$fields).'`) VALUES'.implode(',', $arr);
			print_r($sql);


			if(@mysql_query($sql)){
				$last_id = @mysql_insert_id();
				@mysql_query('COMMIT');
				return $last_id;
			}
			else{
				array_push($this->result, mysql_error());
				@mysql_query('ROLLBACK');
				return -1;
			}
		}

		// Function to update row in database
		public function update($table, $params=array(), $where){
			@mysql_query('START TRANSACTION');
			$args=array();
			foreach($params as $field=>$value) {
				$args[]=$field.'="'.$value.'"';
			}
			$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
			if(@mysql_query($sql)){
				return mysql_affected_rows();
				@mysql_query('COMMIT');
			}else{
				array_push($this->result, mysql_error());
				@mysql_query('ROLLBACK');
				return -1;
			}
		}
	}

}?>