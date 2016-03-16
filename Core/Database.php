<?php

namespace Core {
	use \mysqli;

	class Database extends mysqli{
		private $db_host = 'localhost';
		private $db_user = 'test';
		private $db_pass = '';
		private $db_name = 'test';

		private $mysqli;
		private $query = "";
		private $result;

		function __construct() {
			parent::__construct($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			if(!@mysqli_connect_errno()){
				$this->set_charset("utf8");
				$this->autocommit(false);
				$this->query("SET collation_connection = utf8_general_ci;");
				return true;
			}else{
				array_push($this->result, $this->connect_error);
				return false;
			}
		}

		public function add($sql) {
			$this->query .= $sql;
			return $this;
		}

		public function execute() {
			$this->result = $this->query($this->query);
			$this->query = '';
			return $this;
		}

		public function getResult() {
            $this->execute();
            return $this->result->fetch_all(MYSQLI_ASSOC);
		}

		public function select($table, $fields = '*', $where = null, $order = null, $limit = null) {
            $this->query .= 'SELECT '.$fields.' FROM '.$table;
			if($where !== null){
                $this->query .= ' WHERE '.$where;
			}
			if($order !== null){
                $this->query .= ' ORDER BY '.$order;
			}
			if($limit !== null){
                $this->query .= ' LIMIT '.$limit;
			}
			return $this;
		}

		public function insert($table, $params){
			if (empty($params)) return -2;
			$this->begin_transaction();
			$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('","', $params) . '")';
			if($this->query($sql)){
				$last_id = $this->insert_id;
                $this->commit();
				return $last_id;
			}
			else{
				array_push($this->result, mysql_error());
                $this->rollback();
				return -1;
			}
		}

		public function multiInsert($table, $fields, $params){
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