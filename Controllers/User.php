<?php

namespace Controllers;

use Core\Controller;

class User extends Controller{
    function __construct() {
		print_r(
			array(
				"namespace" => __NAMESPACE__,
				"class" => __CLASS__
			)
		);
		parent::__construct();
    }	
}

?>