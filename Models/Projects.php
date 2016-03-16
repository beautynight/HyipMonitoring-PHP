<?php

namespace Models {

	use Core\Database;
	use\Core\Model;

	class Projects extends Model{
//		private $model;

		function __construct(Database $db) {
			parent::__construct($db);

            $this->db->select('project', '*', null, null, 3);

            var_dump($this->db->getResult());
		}
	}

}?>