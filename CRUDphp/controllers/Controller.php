<?php

require_once __DIR__ . '/../models/Model.php'; // Caminho absoluto, evita erros com níveis de diretórios

class Controller {
    private $model;

    public function __construct(){
        $this->model = new Model(); 
    }

    public function direcionarURL($estudante) {
        $id = $estudante['id'];
        $matricula = $estudante['matricula'];
        $nome = $estudante['nome'];
        $curso = $estudante['curso'];
        $ano_ingresso = $estudante['ano_ingresso'];
        header("Location:router.php?rota=detalhesEstudante&matricula=$matricula&nome=$nome&curso=$curso&anoIngresso=$ano_ingresso&id=$id");
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
            $id_estudante = $_POST["idEstudante"];
            $nome_responsavel = $_POST["nomeResponsavel"];
            $contato_responsavel = $_POST["contatoResponsavel"];
            $contato_responsavel = preg_replace('/\D/', '', $contato_responsavel);
            $parentesco_responsavel = $_POST["parentescoResponsavel"];

            $estudante = $this->model->salvarResponsavel(
                $id_estudante,
                $nome_responsavel,
                $contato_responsavel,
                $parentesco_responsavel
            );
            
            $this->direcionarURL($estudante);
        }
    }

    // EDIÇÕES

    public function editarEstudante() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_estudante = $_POST["idEstudante"];
            $matricula_estudante = $_POST["matriculaEstudante"];
            $nome_estudante = $_POST["novoNomeEstudante"];
            $curso_estudante = $_POST["cursoEstudante"];
            $serie_estudante = $_POST["serieEstudante"];

            switch ($serie_estudante) {
                case "3º Ano":
                    $ano_ingresso_estudante = date("Y") - 2;
                    break;
                case "2º Ano":
                    $ano_ingresso_estudante = date("Y") - 1;
                    break;
                case "1º Ano":
                    $ano_ingresso_estudante = date("Y");
                    break;
                default:
                    $ano_ingresso_estudante = 2022;
                    break;
            }

            $estudante = $this->model->editarEstudante(
                $id_estudante,
                $matricula_estudante,
                $nome_estudante,
                $curso_estudante,
                $ano_ingresso_estudante
            );

           $this->direcionarURL($estudante);
        }
    }

    public function editarResponsavel() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_estudante = $_POST["idEstudante"];
            $nome_responsavel = $_POST["oldNameParent"];
            $novo_nome_responsavel = $_POST["newNameParent"];
            $parentesco_responsavel = $_POST["kinshipParent"];
            $contato_responsavel = $_POST["contactParent"];
            $contato_responsavel = preg_replace('/\D/', '', $contato_responsavel);
            
            $estudante = $this->model->editarResponsavel(
                $id_estudante,
                $nome_responsavel,
                $novo_nome_responsavel,
                $contato_responsavel,
                $parentesco_responsavel
            );

           $this->direcionarURL($estudante);
        }
    }

    // LEITURA / BUSCAS

    public function listar() {
        return $this->model->buscarEstudantes();
    }

    public function listarResponsaveis($id_estudante) {
        return $this->model->buscarResponsaveis($id_estudante);
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

}
?>
