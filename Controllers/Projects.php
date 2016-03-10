<?php

namespace Controllers {
	use Core\Controller;

	class Projects extends Controller{
		function __construct() {
			parent::__construct(__CLASS__);
			echo 'Projects is connected';
		}

		public function show(array $page) {
			print_r($page);
		}
	}

}?>