<?php

namespace Core;
#TODO Написать класс Auth
class Auth {
	private $db;
    function __construct(Database $db) {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__
			)
		);
		//$this->db = $db;
		//$this->model = new '\Models\\'.__CLASS__();
    }	
}

?>