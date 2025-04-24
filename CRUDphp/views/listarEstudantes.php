<?php
require_once 'controllers/Controller.php';
$controller = new Controller();
$estudantes = $controller->listar();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudantes</title>
</head>
<body>
    <h2>Lista de Estudantes</h2>

    <?php if (!empty($estudantes)): ?>
        <table border="1">
            <tr>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Curso</th>
                <th>Ano de Ingresso</th>
                <th>Detalhes</th>
            </tr>
            <?php foreach ($estudantes as $estudante): ?>
                <tr>
                    <td><?= htmlspecialchars($estudante->matricula) ?></td>
                    <td><?= htmlspecialchars($estudante->nome) ?></td>
                    <td><?= htmlspecialchars($estudante->curso) ?></td>
                    <td><?= htmlspecialchars($estudante->ano_ingresso) ?>
                    <td><a href="router.php?rota=detalhesEstudante&matricula=<?=$estudante->matricula?>&nome=<?=$estudante->nome?>&curso=<?=$estudante->curso?>&anoIngresso=<?=$estudante->ano_ingresso?>&id=<?=$estudante->id?>">Ver Detalhes</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum estudante cadastrado.</p>
    <?php endif; ?>

    <br>
    <button onclick="window.location.href='index.php'">Voltar ao Menu</button>
</body>
</html>