<?php

namespace Core {

    class Router {
        private $db;
        private $auth;

        private $uri;

        private $controller = 'Projects';
        private $method     = 'show';
        private $params     = array();

        function __construct() {
            $db     = new Database();
            $auth   = new Auth($db);

            $this->getUri();
            $this->route();


            //$this->method = new \Controllers\User();
            //$this->model = new '\Models\\'.__CLASS__();
        }

        private function getUri() {
            $this->uri = substr($_SERVER["REQUEST_URI"], strlen(dirname($_SERVER['SCRIPT_NAME'])));
            $this->uri = preg_replace('/[^a-zA-Z0-9-_\/]/', '', $this->uri);
            $this->uri = explode('/', strtolower(trim($this->uri,'/')));
        }

        private function route() {
            foreach($this->uri as $k => $v) {
                $var = array_shift($this->uri); echo $var."\n"; print_r($this->uri);
            }
        }
    }

}?>