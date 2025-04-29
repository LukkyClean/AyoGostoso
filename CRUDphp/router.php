<?php
require_once 'controllers/Controller.php';

$controller = new Controller();
$rota = $_GET['rota'] ?? 'listar'; // Rota padrão

// ========== REQUISIÇÕES POST ==========
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($rota) {
        case 'cadastrarEstudante':
            $controller->cadastrarEstudante();
            break;

        case 'cadastrarResponsavel':
            $controller->cadastrarResponsavel();
            break;

        case 'editarEstudante':
            $controller->editarEstudante();
            break;

        case 'editarResponsavel':
            $controller->editarResponsavel();
            break;

        default:
            $controller->atualizar();
            break;
    }
    exit;
}

// ========== REQUISIÇÕES GET ==========
switch ($rota) {
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

    case 'detalhesEstudante':
        require_once 'views/detalhesEstudante.php';
        break;

    case 'confirmarDeletar':
        $tipo = $_GET['tipo'];
        $id = $_GET['id'] ?? null;

        if ($id === null) {
            die('ID não informado.');
        }

        switch ($tipo) {
            case 'estudante':
                $controller->deletarEstudante($id);
                break;

            case 'responsavel':
                $controller->deletarResponsavel($id);
                break;
        }
        exit; // Impede carregamento de outras views após ação

    default:
        require_once 'views/listarEstudantes.php';
        break;
}
?>
