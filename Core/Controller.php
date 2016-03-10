<?php

namespace Core;

class Controller {
	private $model;
	
    function __construct($rrr) {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__
			)
		);
		$modelClass = '\Models\\'.(new \ReflectionClass($this))->getShortName();
		$this->model = new $modelClass();
    }
}

?>