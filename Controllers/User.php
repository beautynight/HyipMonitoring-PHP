<?php

namespace Controllers;

use Core\Controller;

class User extends Controller{
    function __construct() {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__,
				"title" => "class User extends Controller\n"
			)
		);
		parent::__construct();
    }	
}

?>