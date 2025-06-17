<?php 
    require_once __DIR__ . '/../models/Model.php';

    class Controller {

        private $model;

        public function __construct() {
            $this->model = new Model();
        }
    }
?>