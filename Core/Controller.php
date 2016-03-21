<?php

namespace Core {

	class Controller {
		public $model;

		function __construct($className, Database $db) {
			$modelClass = '\Models\\'.(substr($className, strrpos($className, '\\') + 1));
			$this->model = new $modelClass($db);
		}
	}

}?>