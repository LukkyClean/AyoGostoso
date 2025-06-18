<?php 
    require_once __DIR__ . '/../models/Model.php';

    header('Content-Type: application/json');
    $input = json_decode(file_get_contents("php://input"), true);

    $model = new Model();

?>