<pre><?php

error_reporting (E_ALL);
ini_set('display_errors', 1);

//define('DS', DIRECTORY_SEPARATOR);
//
//print_r($_SERVER['DOCUMENT_ROOT']);echo "\n";


spl_autoload_extensions(".php");
spl_autoload_register(function ($className) {
    require_once($className . ".php");
//	require_once(__DIR__ . DS .  $className . ".php");
});


$router 	= new Core\Router();


//$db 	= new Libs\Database();
//$user 	= new Controllers\User();
//$db = new Libs\DB();


