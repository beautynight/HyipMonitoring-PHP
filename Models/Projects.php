<?php

namespace Models;

class Projects {
	private $model;

	function __construct() {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__
			)
		);
		/*$modelClass = '\Models\\'.__CLASS__;
		$this->model = new $modelClass();*/
	}
}

?>