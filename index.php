<?php
namespace {
    echo '<pre>';
//    define('DS', DIRECTORY_SEPARATOR);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    spl_autoload_extensions(".php");
    spl_autoload_register(function ($className) {
        require_once($className . ".php");
    });

    new Core\Router();
}


