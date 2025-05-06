<?php
class Model {
    private $connect;
    
    public function __construct() {
        try {
            $this->connect = new PDO("mysql:host=localhost;dbname=identificar_responsavel", 'root', '3d2y');
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function buscarEstudante($id_estudante) {
       try {
            $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes WHERE id = :id_estudante");
            $stmt->bindParam(":id_estudante", $id_estudante);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                $estudante = $stmt->fetch(PDO::FETCH_ASSOC);
                return $estudante;
            }
       } catch (PDOException $e) {
            die("Erro ao buscar estudante: " . $e->getMessage());
       }
    }

    public function salvarEstudante($matricula_estudante, $nome_estudante, $curso_estudante, $ano_ingresso_estudante, $nome_responsavel, $contato_responsavel, $parentesco_responsavel){
        try {
            $stmt = $this->connect->prepare("
                INSERT INTO estudantes (matricula, nome, curso, ano_ingresso) 
                VALUES (:matricula, :nome, :curso, :ano_ingresso)
            ");
            $stmt->bindParam(':matricula', $matricula_estudante);
            $stmt->bindParam(':nome', $nome_estudante);
            $stmt->bindParam(':curso', $curso_estudante);
            $stmt->bindParam(':ano_ingresso', $ano_ingresso_estudante);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                $id_estudante = $this->connect->lastInsertId();
                for($i = 0; $i < count($nome_responsavel); $i++){
                    $stmt = $this->connect->prepare("
                    INSERT INTO responsaveis (id_estudante, nome, contato, parentesco) 
                    VALUES (:id_estudante, :nome, :contato, :parentesco)
                    ");
                    $stmt->bindParam(':id_estudante', $id_estudante);
                    $stmt->bindParam(':nome', $nome_responsavel[$i]);
                    $stmt->bindParam(':contato', $contato_responsavel[$i]);
                    $stmt->bindParam(':parentesco', $parentesco_responsavel[$i]);
                    $stmt->execute();
                }
            }
        } catch (PDOException $e) {
            die("Erro ao salvar estudante: " . $e->getMessage());
        }
    }

    public function salvarResponsavel($id_estudante, $nome_responsavel, $contato_responsavel, $parentesco_responsavel){
        try {
            $stmt = $this->connect->prepare("
            INSERT INTO responsaveis (id_estudante, nome, contato, parentesco) 
            VALUES (:id_estudante, :nome, :contato, :parentesco)
            ");
            $stmt->bindParam(':id_estudante', $id_estudante);
            $stmt->bindParam(':nome', $nome_responsavel);
            $stmt->bindParam(':contato', $contato_responsavel);
            $stmt->bindParam(':parentesco', $parentesco_responsavel);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                return $this->buscarEstudante($id_estudante);
            }
        } catch (PDOException $e) {
            die("Erro ao salvar responsavel: " . $e->getMessage());
        }
    }

    public function editarEstudante($id_estudante, $matricula_estudante, $nome_estudante, $curso_estudante, $ano_ingresso_estudante) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE estudantes 
                SET matricula = :matricula, nome = :nome, curso = :curso, ano_ingresso = :ano_ingresso
                WHERE id = :id_estudante
            ");
            $stmt->bindParam(':id_estudante', $id_estudante);
            $stmt->bindParam(':matricula', $matricula_estudante);
            $stmt->bindParam(':nome', $nome_estudante);
            $stmt->bindParam(':curso', $curso_estudante);
            $stmt->bindParam(':ano_ingresso', $ano_ingresso_estudante);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                return $this->buscarEstudante($id_estudante);
            }
            exit;
        } catch (PDOException $e) {
            die("Erro ao editar estudante: " . $e->getMessage());
        } 
    }

    public function editarResponsavel($id_estudante, $nome_responsavel, $novo_nome_responsavel, $contato_responsavel, $parentesco_responsavel) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE responsaveis 
                SET nome = :nome, contato = :contato, parentesco = :parentesco
                WHERE id_estudante = :id_estudante AND nome = :antigo_nome
            ");
            $stmt->bindParam(':nome', $novo_nome_responsavel);
            $stmt->bindParam(':contato', $contato_responsavel);
            $stmt->bindParam(':parentesco', $parentesco_responsavel);
            $stmt->bindParam(':id_estudante', $id_estudante);
            $stmt->bindParam(':antigo_nome', $nome_responsavel);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                return $this->buscarEstudante($id_estudante);
            }
            exit;
        } catch (PDOException $e) {
            die("Erro ao editar responsavel: " . $e->getMessage());
        } 
    }

    public function buscarEstudantes() {
        try {
            $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes ORDER BY nome ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar estudantes: " . $e->getMessage());
        }
    }

    public function buscarResponsaveis($id_estudante) {
        try {
            $stmt = $this->connect->prepare("SELECT id, nome, contato, parentesco FROM responsaveis WHERE id_estudante = :id_estudante");
            $stmt->bindParam(":id_estudante", $id_estudante);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar responsável: " . $e->getMessage());
        }
    }

    // Adicionar função de deletar no Model.php
    public function deletarEstudante($id) {
        try {
            $stmt = $this->connect->prepare("DELETE FROM estudantes WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $executeStatus = $stmt->execute();
            if ($executeStatus) {
                $stmt = $this->connect->prepare("DELETE FROM responsaveis WHERE id_estudante = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $executeStatus = $stmt->execute();
            }
        } catch (PDOException $e) {
            die("Erro ao excluir estudante: " . $e->getMessage());
        }
    }

    public function deletarResponsavel($id) {
        try {
            $stmt = $this->connect->prepare("SELECT id_estudante FROM responsaveis WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $estudante = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = $this->connect->prepare("DELETE FROM responsaveis WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $executeStatus = $stmt->execute();
            if ($executeStatus) {
                $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes WHERE id = :id_estudante");
                $stmt->bindParam(":id_estudante", $estudante['id_estudante']);
                $executeStatus = $stmt->execute();
                if ($executeStatus) {
                    $estudante = $stmt->fetch(PDO::FETCH_ASSOC);
                    $matricula = $estudante['matricula'];
                    $nome = $estudante['nome'];
                    $curso = $estudante['curso'];
                    $ano_ingresso = $estudante['ano_ingresso'];
                    $id = $estudante['id'];
                    header("Location:router.php?rota=detalhesEstudante&matricula=$matricula&nome=$nome&curso=$curso&anoIngresso=$ano_ingresso&id=$id");
                }
            }
        } catch (PDOException $e) {
            die("Erro ao excluir responsavel: " . $e->getMessage());
        }
    }
    
}

?>