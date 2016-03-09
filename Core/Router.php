<?php

namespace Core {

    class Router {
        private $db;
        private $auth;

        private $uri;

        private $controller;
        private $action;
        private $params;

        function __construct() {
            $db     = new Database();
            $auth   = new Auth($db);

            $this->getUri();
            $this->parseUri();
            $this->route();
        }

        private function getUri() {
            $this->uri = substr($_SERVER["REQUEST_URI"], strlen(dirname($_SERVER['SCRIPT_NAME'])));
            $this->uri = preg_replace('/[^a-zA-Z0-9-_\/]/', '', $this->uri);
            $this->uri = explode('/', strtolower(trim($this->uri,'/')));
        }

        private function parseUri() {
            $this->controller   = count($this->uri) ? ucfirst(array_shift($this->uri)) : '';
            $this->action       = count($this->uri) ? array_shift($this->uri) : '';
            $this->params       = count($this->uri) ? $this->uri : array();
        }

        private function route() {
            $controllerClass = 'Controllers\\'.$this->controller;

            if(file_exists($controllerClass.'.php')){
                $controller = new $controllerClass();
                if (is_callable(array($controller, 'show'))) {
                    call_user_func_array(array($controller, $this->action), array($this->params));
                }
            }
        }
    }

}?>