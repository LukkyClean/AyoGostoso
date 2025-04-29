<?php
class Model {
    private $connect;
    
    public function __construct() {
        try {
            $this->connect = new PDO("mysql:host=localhost;dbname=identificar_responsavel", 'root', 'mysql2024');
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function salvarEstudante($matricula, $nomeAluno, $curso, $anoIngresso, $nomeResponsavel, $contatoResponsavel, $parentescoResponsavel){
        try {
            $stmt = $this->connect->prepare("
                INSERT INTO estudantes (matricula, nome, curso, ano_ingresso) 
                VALUES (:matricula, :nome, :curso, :ano_ingresso)
            ");
            $stmt->bindParam(':matricula', $matricula);
            $stmt->bindParam(':nome', $nomeAluno);
            $stmt->bindParam(':curso', $curso);
            $stmt->bindParam(':ano_ingresso', $anoIngresso);
            $executeStatus = $stmt->execute();
            if($executeStatus){
                $idEstudante = $this->connect->lastInsertId();
                for($i = 0; $i < count($nomeResponsavel); $i++){
                    $stmt = $this->connect->prepare("
                    INSERT INTO responsaveis (id_estudante, nome, contato, parentesco) 
                    VALUES (:id_estudante, :nomeResponsavel, :contatoResponsavel, :parentescoResponsavel)
                    ");
                    $stmt->bindParam(':id_estudante', $idEstudante);
                    $stmt->bindParam(':nomeResponsavel', $nomeResponsavel[$i]);
                    $stmt->bindParam(':contatoResponsavel', $contatoResponsavel[$i]);
                    $stmt->bindParam(':parentescoResponsavel', $parentescoResponsavel[$i]);
                    $stmt->execute();
                }
            }
        } catch (PDOException $e) {
            die("Erro ao salvar estudante: " . $e->getMessage());
        }
    }

    public function salvarResponsavel($nomeResponsavel,$contatoResponsavel, $parentescoResponsavel, $idEstudante){
        try {
            $stmt = $this->connect->prepare("
            INSERT INTO responsaveis (id_estudante, nome, contato, parentesco) 
            VALUES (:id_estudante, :nomeResponsavel, :contatoResponsavel, :parentescoResponsavel)
            ");
            $stmt->bindParam(':id_estudante', $idEstudante);
            $stmt->bindParam(':nomeResponsavel', $nomeResponsavel);
            $stmt->bindParam(':contatoResponsavel', $contatoResponsavel);
            $stmt->bindParam(':parentescoResponsavel', $parentescoResponsavel);
            $executeStatus = $stmt->execute();
            if ($executeStatus) {
                $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes WHERE id = :id_estudante");
                $stmt->bindParam(":id_estudante", $idEstudante);
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
            exit;
        } catch (PDOException $e) {
            die("Erro ao salvar estudante: " . $e->getMessage());
        }
    }

    public function editarEstudante($idEstudante, $novoNomeEstudante, $matriculaEstudante, $cursoEstudante, $anoIngresso) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE estudantes 
                SET matricula = :matricula, nome = :nome, curso = :curso, ano_ingresso = :anoIngresso
                WHERE id = :idEstudante
            ");
            $stmt->bindParam(':matricula', $matriculaEstudante);
            $stmt->bindParam(':nome', $novoNomeEstudante);
            $stmt->bindParam(':curso', $cursoEstudante);
            $stmt->bindParam(':anoIngresso', $anoIngresso);
            $stmt->bindParam(':idEstudante', $idEstudante);
            $executeStatus = $stmt->execute();
            if ($executeStatus) {
                header("Location:router.php?rota=detalhesEstudante&matricula=$matriculaEstudante&nome=$novoNomeEstudante&curso=$cursoEstudante&anoIngresso=$anoIngresso&id=$idEstudante");
            }
            exit;
        } catch (PDOException $e) {
            die("Erro ao editar estudante: " . $e->getMessage());
        } 
    }

    public function editarResponsavel($idEstudante, $oldNameParent, $newNameParent, $kinshipParent, $contactParent) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE responsaveis 
                SET nome = :newNameParent, contato = :contactParent, parentesco = :kinshipParent
                WHERE id_estudante = :idEstudante AND nome = :oldNameParent
            ");
            $stmt->bindParam(':newNameParent', $newNameParent);
            $stmt->bindParam(':contactParent', $contactParent);
            $stmt->bindParam(':kinshipParent', $kinshipParent);
            $stmt->bindParam(':idEstudante', $idEstudante);
            $stmt->bindParam(':oldNameParent', $oldNameParent);
            $executeStatus = $stmt->execute();
            if ($executeStatus) {
                $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes WHERE id = :id_estudante");
                $stmt->bindParam(":id_estudante", $idEstudante);
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

    public function buscarResponsaveis($idEstudante) {
        try {
            $stmt = $this->connect->prepare("SELECT id, nome, contato, parentesco FROM responsaveis WHERE id_estudante = :id_estudante");
            $stmt->bindParam(":id_estudante", $idEstudante);
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

    public function buscarPorMatricula($matricula) {
        try {
            $stmt = $this->connect->prepare("SELECT * FROM estudantes WHERE matricula = :matricula");
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar estudante: " . $e->getMessage());
        }
    }

    public function atualizarEstudante($matricula, $nome, $curso, $ano_ingresso) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE estudantes 
                SET nome = :nome, curso = :curso, ano_ingresso = :ano_ingresso 
                WHERE matricula = :matricula
            ");
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':curso', $curso, PDO::PARAM_STR);
            $stmt->bindParam(':ano_ingresso', $ano_ingresso, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao atualizar estudante: " . $e->getMessage());
        }
    }
}

?>