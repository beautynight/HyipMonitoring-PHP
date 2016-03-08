<?php

namespace Core;

class Controller {
	public $model;
	
    function __construct() {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__,
				"title" => "class Controller\n"
			)
		);
		//$this->model = new '\Models\\'.__CLASS__();
    }	
}

?>