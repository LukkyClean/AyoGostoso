<?php
require_once 'controllers/Controller.php';

$controller = new Controller();

$rota = $_GET['rota'] ?? 'listar'; // Se não tiver definida, define com a rota padrão

// Processa requisições POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch($rota) {
        case 'cadastrarEstudante':
            $controller->cadastrarEstudante();
            break;
        case 'cadastrarResponsavel':
            $controller->cadastrarResponsavel();
            break;
        default:
            $controller->atualizar();
            break;
    }
    exit;
}

// Processa requisições GET
switch($rota) {
    case 'cadastrarEstudante':
        require_once 'views/estudanteCadastro.php';
        break;
    case 'cadastrarResponsavel':
        require_once 'views/responsavelCadastro.php';
        break;
    case 'deletar':
        require_once 'views/listarDeletar.php';
        break;
    case 'atualizar':
        require_once 'views/listarAtualizar.php';
        break; 
    case 'formAtualizar': 
        require_once 'views/formAtualizar.php';
        break; 
    case 'confirmarDeletar':
        $controller->deletar(); // Aqui deletamos o estudante
        exit; // Evita que carregue outros arquivos após a execução
    case 'listar':
    default:
        require_once 'views/listarEstudantes.php';
        break;
}
?>