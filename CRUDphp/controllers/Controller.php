<?php

require_once __DIR__ . '/../models/Model.php'; // Caminho absoluto, evita erros com níveis de diretórios

class Controller {
    private $model;

    public function __construct(){
        $this->model = new Model(); 
    }

    // CADASTROS

    public function cadastrarEstudante() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $matricula = $_POST["matricula"];
            $nomeAluno = $_POST["nomeAluno"];
            $curso = $_POST["curso"];
            $ano_ingresso = $_POST["ano_ingresso"];
            $nomesResponsaveis = $_POST["nomeResponsavel"];
            $contatosResponsaveis = $_POST["contatoResponsavel"];
            $parentescosResponsaveis = $_POST["parentescoResponsavel"];

            $this->model->salvarEstudante(
                $matricula,
                $nomeAluno,
                $curso,
                $ano_ingresso,
                $nomesResponsaveis,
                $contatosResponsaveis,
                $parentescosResponsaveis
            );

            header("Location:router.php?rota=cadastrar&sucesso=1");
            exit;
        }
    }

    public function cadastrarResponsavel() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nomeResponsavel = $_POST["nomeResponsavel"];
            $contatoResponsavel = $_POST["contatoResponsavel"];
            $contatoResponsavel = preg_replace('/\D/', '', $contatoResponsavel);
            $parentescoResponsavel = $_POST["parentescoResponsavel"];
            $idEstudante = $_POST["idEstudante"];

            $this->model->salvarResponsavel(
                $nomeResponsavel,
                $contatoResponsavel,
                $parentescoResponsavel,
                $idEstudante
            );
            exit;
        }
    }

    // EDIÇÕES

    public function editarEstudante() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idEstudante = $_POST["idEstudante"];
            $novoNomeEstudante = $_POST["novoNomeEstudante"];
            $matriculaEstudante = $_POST["matriculaEstudante"];
            $cursoEstudante = $_POST["cursoEstudante"];
            $serieEstudante = $_POST["serieEstudante"];

            switch ($serieEstudante) {
                case "3º Ano":
                    $anoIngresso = date("Y") - 2;
                    break;
                case "2º Ano":
                    $anoIngresso = date("Y") - 1;
                    break;
                case "1º Ano":
                    $anoIngresso = date("Y");
                    break;
                default:
                    $anoIngresso = 2022;
                    break;
            }

            $this->model->editarEstudante(
                $idEstudante,
                $novoNomeEstudante,
                $matriculaEstudante,
                $cursoEstudante,
                $anoIngresso
            );
        }
    }

    public function editarResponsavel() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idEstudante = $_POST["idEstudante"];
            $oldNameParent = $_POST["oldNameParent"];
            $newNameParent = $_POST["newNameParent"];
            $kinshipParent = $_POST["kinshipParent"];
            $contactParent = $_POST["contactParent"];
            $contactParent = preg_replace('/\D/', '', $contactParent);
            
            $this->model->editarResponsavel(
                $idEstudante,
                $oldNameParent,
                $newNameParent,
                $kinshipParent,
                $contactParent
            );
        }
    }

    // LEITURA / BUSCAS

    public function listar() {
        return $this->model->buscarEstudantes();
    }

    public function listarResponsaveis($idEstudante) {
        return $this->model->buscarResponsaveis($idEstudante);
    }

    public function buscarPorMatricula($matricula) {
        return $this->model->buscarPorMatricula($matricula);
    }

    // DELEÇÃO

    public function deletarEstudante($id) {
        $this->model->deletarEstudante($id);
        header("Location:router.php?rota=listar");
        exit;
    }

    public function deletarResponsavel($id) {
        $this->model->deletarResponsavel($id);
        exit;
    }

    // ATUALIZAÇÃO (método separado do editar)

    public function atualizar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $matricula = $_POST["matricula"];
            $nome = $_POST["nome"];
            $curso = $_POST["curso"];
            $ano_ingresso = $_POST["ano_ingresso"];

            $this->model->atualizarEstudante(
                $matricula,
                $nome,
                $curso,
                $ano_ingresso
            );

            header("Location: router.php?rota=listar&atualizado=1");
            exit;
        }
    }
}
?>
