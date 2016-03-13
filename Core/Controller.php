<?php

namespace Core {

	class Controller {
		public $model;

		function __construct($className, Database $db) {
			/*print_r(
				array(
					"namespace" => __NAMESPACE__,
					"class" => __CLASS__
				)
			);*/

			$modelClass = '\Models\\'.(substr($className, strrpos($className, '\\') + 1));
			$this->model = new $modelClass($db);
		}
	}

}?>