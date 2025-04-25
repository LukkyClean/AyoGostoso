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

    public function salvarResponsavel($nomeResponsavel,$contatoResponsavel, $parentescoResponsavel, $nomeAluno){
        try {
            $stmt = $this->connect->prepare("SELECT id FROM estudantes WHERE nome = :nome");
            $stmt->bindParam(':nome', $nomeAluno);
            $executeStatus = $stmt->execute();
            if($executeStatus){
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $idEstudante = $resultado['id'];
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
                        header("Location:router.php?rota=cadastrarResponsavel&sucesso=1");
                    } else {
                        header("Location:router.php?rota=cadastrarResponsavel&sucesso=0");
                    }
                } else {
                    header("Location:router.php?rota=cadastrarResponsavel&sucesso=0");
                }
                exit;
            }

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
            $stmt = $this->connect->prepare("SELECT nome, contato, parentesco FROM responsaveis WHERE id_estudante = :id_estudante");
            $stmt->bindParam(":id_estudante", $idEstudante);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar responsável: " . $e->getMessage());
        }
    }

    // Adicionar função de deletar no Model.php
    public function deletarEstudante($matricula) {
        try {
            $stmt = $this->connect->prepare("DELETE FROM estudantes WHERE matricula = :matricula");
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao excluir estudante: " . $e->getMessage());
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