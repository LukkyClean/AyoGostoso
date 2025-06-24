<?php
    class Model {

        protected $connect;
        
        public function __construct() {
            try{
                $this->connect = new mysqli("localhost", "root", "", "busy_bus");

                if ($this->connect->connect_error) {
                    throw new Exception("Erro de conexão: " . $this->connect->connect_error);
                }
            } catch (Exception $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }

        public function createUser($name, $email, $password, $birthday) {
            $name = $this->connect->real_escape_string($name);
            $email = $this->connect->real_escape_string($email);
            $password = $this->connect->real_escape_string($password);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $birthday = $this->connect->real_escape_string($birthday);
            
            if ($this->connect->query("INSERT INTO usuario (name, email, password, birthday) VALUES ('$name', '$email', '$password', '$birthday')")) {
                return json_encode(['status' => 'success', 'msg' => 'Conta criada com sucesso.']);
            } else {
                return json_encode(['status' => 'error', 'msg' => 'Falha ao criar a conta.']);
            }
            exit;
        }
    }
?>