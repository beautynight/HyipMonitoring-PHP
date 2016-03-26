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

			$payments  = $this->model->db->select('payments', 'id, name', null, 'pos');
			$languages = $this->model->db->select('languages', 'id, name, own_name, flag', 'pos is not null', 'pos');
			$hidden_languages = $this->model->db->select('languages', 'id, name, own_name, flag', 'pos is null', 'name');
			echo (new View('Addproject', ['payments' => $payments, 'languages' => $languages, 'hidden_languages' => $hidden_languages]))->get();

			//$this->model->query('select * from project');
		}

		public function add() {
			$this->model->saveProject($_POST);
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