<?php
    class Model {

        private $connect;

        public function __construct() {
            try{
                $this->connect = new PDO("mysql:host=localhost;dbname=identificar_responsavel", 'root', 'mysql2024');
                $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                die("Conectado com sucesso!");
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
    }
?>