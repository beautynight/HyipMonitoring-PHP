<?php

namespace Controllers {
	use Core\Controller;
	use Core\Database;

	class Projects extends Controller{
		function __construct(Database $db) {
			parent::__construct(__CLASS__, $db);
		}

		public function show(array $page) {
			print_r($page);
			$this->model->query('select * from project');
		}
	}

}?>