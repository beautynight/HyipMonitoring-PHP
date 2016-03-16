<?php

namespace Models {

	use Core\Database;
	use\Core\Model;

	class Projects extends Model{
//		private $model;

		function __construct(Database $db) {
			/*print_r(
				array(
					"namespace" => __NAMESPACE__,
					"class" => __CLASS__
				)
			);*/
			parent::__construct($db);
			/*$modelClass = '\Models\\'.__CLASS__;
            $this->model = new $modelClass();*/

            $this->db->add('select * from project');

            var_dump($this->db->getResult());
		}
	}

}?>