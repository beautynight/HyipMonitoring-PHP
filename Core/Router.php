<?php

namespace Core {

    class Router {
        private $db;
        private $auth;

        private $controller = 'Projects';
        private $method = '';
        private $params = '';

        /**
         * Router constructor.
         * @param $uri
         */
        function __construct($uri) {
            print_r(
                array(
                    "namespace" => __NAMESPACE__,
                    "class" => __CLASS__,
                    "title" => "class Router\n"
                )
            );

            $db     = new Database();
            $auth   = new Auth($db);

            //$this->method = new \Controllers\User();
            //$this->model = new '\Models\\'.__CLASS__();
        }
    }

}?>