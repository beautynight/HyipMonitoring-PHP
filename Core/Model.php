<?php

namespace Core;

class Model {
	private $db;
	
    function __construct(Database $db) {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__
			)
		);
		$this->db = $db;
    }	
}

?>