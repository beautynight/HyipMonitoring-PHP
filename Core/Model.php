<?php

namespace Core;

class Model {
	public $db;
	
    function __construct() {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__,
				"title" => "class Controller\n"
			)
		);
		$this->db = new \Libs\Database();
    }	
}

?>