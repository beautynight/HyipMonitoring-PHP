<?php

namespace Controllers {

	class Projects {
		function __construct() {
			echo 'DB is connected';
		}

		public function show(array $page) {
			print_r($page);
		}
	}

}?>