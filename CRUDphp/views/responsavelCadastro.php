<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Responsável</title>
</head>
<body>
    <h2>Cadastro de Responsável</h2>
    
    <?php if(isset($_GET['sucesso'])): ?>
        <?php if ($_GET['sucesso'] == '1'): ?>
            <p style="color: green;">Responsável cadastrado com sucesso!</p>
        <?php else: ?>
            <p style="color: red;">Aluno não encontrado.</p>
        <?php endif; ?>
    <?php endif; ?>

    <form action="router.php?rota=cadastrarResponsavel" method="POST">

        <div id="responsaveis">
            <div class="responsavel">
                <label>Nome Responsável:</label>
                <input type="text" name="nomeResponsavel" placeholder="Nome do responsável" maxlength="100" required>

                <label>Contato Responsável:</label>
                <input type="text" name="contatoResponsavel" placeholder="Contato responsável" maxlength="15" required>

                <label>Nome Aluno:</label>
                <input type="text" name="nomeAluno" placeholder="Nome do estudante" maxlength="100" required>

                <label>Parentesco:</label>
                <input type="text" name="parentescoResponsavel" placeholder="Parentesco" maxlength="10" required>
            </div>
        </div>

        <br><br>
        <input type="submit" value="Cadastrar">
    </form>

    <br>
    <button onclick="window.location.href='index.php'">Voltar ao Menu</button>
</body>
</html>


