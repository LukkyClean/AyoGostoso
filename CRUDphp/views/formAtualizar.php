<?php
require_once 'controllers/Controller.php';

$controller = new Controller();

$matricula = $_GET['matricula'] ?? null;

if (!$matricula) {
    echo "<p>Matrícula não informada.</p>";
    echo '<button onclick="window.location.href=\'router.php?rota=atualizar\'">Voltar</button>';
    exit;
}

$estudante = $controller->buscarPorMatricula($matricula);

if (!$estudante) {
    echo "<p>Estudante não encontrado.</p>";
    echo '<button onclick="window.location.href=\'router.php?rota=atualizar\'">Voltar</button>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Estudante</title>
</head>
<body>
    <h2>Atualizar Estudante</h2>

    <form action="router.php?rota=atualizar" method="POST">
        <input type="hidden" name="matricula" value="<?= htmlspecialchars($estudante->matricula) ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($estudante->nome) ?>" required>
        <br>

        <label>Curso:</label>
        <input type="text" name="curso" value="<?= htmlspecialchars($estudante->curso) ?>" required>
        <br>

        <label>Ano de Ingresso:</label>
        <input type="number" name="ano_ingresso" value="<?= htmlspecialchars($estudante->ano_ingresso) ?>" required>
        <br>

        <label>Nome Responsável:</label>
        <input type="text" name="nomeResponsavel" value="<?= htmlspecialchars($estudante->nomeResponsavel) ?>" required>
        <br>

        <label>Contato Responsável:</label>
        <input type="text" name="contatoResponsavel" value="<?= htmlspecialchars($estudante->contatoResponsavel) ?>" required>
        <br>

        <label>Parentesco:</label>
        <input type="number" name="ano_ingresso" value="<?= htmlspecialchars($estudante->parentescoResponsavel) ?>" required>
        <br>

        <button type="submit">Atualizar</button>
    </form>

    <button onclick="window.location.href='router.php?rota=atualizar'">Cancelar</button>
</body>
</html>