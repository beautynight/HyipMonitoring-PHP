<?php

namespace Controllers {
	use Core\Controller;
	use Core\Database;
	use Core\View;

	class Projects extends Controller{
		function __construct(Database $db) {
			parent::__construct(__CLASS__, $db);
		}

		public function show(array $page) {
//			print_r($page);

			/*$ajax = false;
			$content = (new View('Addproject', ['aaa' => 'a', 'bbb' => 'b']))->get();
			if ($ajax) {
				echo $content;
			}
			else {
				echo (new View('Layout', ['content' => $content]))->get();
			}

			echo (new View('Addproject', ['aaa' => 'a', 'bbb' => 'b']))->get();*/

			echo (new View('Addproject', ['aaa' => 'a', 'bbb' => 'b']))->get();

			//$this->model->query('select * from project');
		}
/*
		public function add(array $page) {
//			print_r($page);

			$ajax = false;
			$content = (new View('Addproject', ['aaa' => 'a', 'bbb' => 'b']))->get();
			if ($ajax) {
				echo $content;
			}
			else {
				echo (new View('Layout', ['content' => $content]))->get();
			}

			//$this->model->query('select * from project');
		}*/
	}

}?>