<?php

namespace Core {
	use \mysqli;

	class Database extends mysqli{
		private $db_host = 'localhost';
		private $db_user = 'test';
		private $db_pass = '';
		private $db_name = 'test';

		private $query = "";
		private $transaction_started = false;
		private $result;
		private $errors = [];

		function __construct() {
			parent::__construct($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			if(!@mysqli_connect_errno()){
				$this->set_charset("utf8");
				$this->autocommit(false);
				$this->query("SET collation_connection = utf8_general_ci;");
				return true;
			}else{
				$this->errors[] = -1;
				array_push($this->result, $this->connect_error);
				return false;
			}
		}

		public function add($sql) {
			$this->query .= $sql;
			return $this;
		}

		public function begin() {
			$this->transaction_started = true;
			$this->begin_transaction();
			return $this;
		}

		public function execute() {
			$this->result = $this->query($this->query);
			if ($this->transaction_started) {
				if (!empty($this->errors) || $this->error !== '') $this->rollback();
				else $this->commit();
				$this->transaction_started = false;
			}
			$this->query = '';
			return $this;
		}

		public function free() {
			$this->errors = [];
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

		public function insert($table, array $params){
			if (empty($params)) $this->errors[] = -2;
			$this->query .= 'INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('","', $params) . '")';
			return $this;
		}

		public function multiInsert($table, $fields, array $params){
			if (empty($params) || !is_array($params)) $this->errors[] = -2;
			$cnt = count($params[0]);

			foreach($params as $k => $v) {
				if (!is_array($v) || count($v) !== $cnt) $this->errors[] = -3;
			}

			// Rotate array
			array_unshift($params, null);
			$params = call_user_func_array("array_map", $params);

			$arr = [];
			foreach($params as $k => $v) {
				$arr[] = '("' . implode('","', $v) . '")';
			}

			$this->query .= 'INSERT INTO `'.$table.'` (`'.implode('`,`',$fields).'`) VALUES'.implode(',', $arr);
			return $this;
		}

		public function update($table, array $params, $where){
			$args=[];
			foreach($params as $field=>$value) {
				$args[] = $field.'="'.$value.'"';
			}
			$this->query .= 'UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
			return $this;
		}
	}

}?>