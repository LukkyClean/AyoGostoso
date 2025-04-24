<?php

require_once __DIR__ . '/../models/Model.php'; // Caminho absoluto, evita erros com níveis de diretórios

class Controller {
private $model;

public function __construct(){
    $this->model = new Model(); 
}

public function cadastrarEstudante() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matricula = $_POST["matricula"];
        $nomeAluno = $_POST["nomeAluno"];
        $curso = $_POST["curso"];
        $ano_ingresso = $_POST["ano_ingresso"];
        $nomesResponsaveis = $_POST["nomeResponsavel"];
        $contatosResponsaveis = $_POST["contatoResponsavel"];
        $parentescosResponsaveis = $_POST["parentescoResponsavel"];

        $this->model->salvarEstudante($matricula, $nomeAluno, $curso, $ano_ingresso, $nomesResponsaveis, $contatosResponsaveis, $parentescosResponsaveis);

        header("Location:router.php?rota=cadastrar&sucesso=1");
        exit;
    }
}

public function cadastrarResponsavel() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomeResponsavel = $_POST["nomeResponsavel"];
        $contatoResponsavel = $_POST["contatoResponsavel"];
        $parentescoResponsavel = $_POST["parentescoResponsavel"];
        $nomeAluno = $_POST["nomeAluno"];

        $this->model->salvarResponsavel($nomeResponsavel, $contatoResponsavel, $parentescoResponsavel, $nomeAluno);

        header("Location:router.php?rota=cadastrar&sucesso=1");
        exit;
    }
}

public function listar() {
    return $this->model->buscarEstudantes();
}

public function listarResponsaveis($idEstudante) {
    return $this->model->buscarResponsaveis($idEstudante);
}

public function deletar() {
    if (isset($_GET['matricula'])) {
        $matricula = $_GET['matricula'];
        $this->model->deletarEstudante($matricula);
    }
    header("Location:router.php?rota=listar"); // Redireciona para a lista de estudantes
    exit;
}

public function buscarPorMatricula($matricula) {
    return $this->model->buscarPorMatricula($matricula);
}

public function atualizar() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matricula = $_POST["matricula"];
        $nome = $_POST["nome"];
        $curso = $_POST["curso"];
        $ano_ingresso = $_POST["ano_ingresso"];

        $this->model->atualizarEstudante($matricula, $nome, $curso, $ano_ingresso);

        header("Location: router.php?rota=listar&atualizado=1");
        exit;
    }
}

}
?>