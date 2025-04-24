<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Estudante</title>
</head>
<body>
    <h2>Cadastro de Estudante</h2>
    
    <?php if(isset($_GET['sucesso'])): ?>
        <p style="color: green;">Estudante cadastrado com sucesso!</p>
    <?php endif; ?>

    <form action="router.php?rota=cadastrarEstudante" method="POST">
        <label>Matrícula:</label>
        <input type="text" name="matricula" placeholder="Número da matrícula" maxlength="10" required>

        <label>Nome Aluno:</label>
        <input type="text" name="nomeAluno" placeholder="Nome do estudante" maxlength="100" required>

        <label>Curso:</label>
        <input type="text" name="curso" placeholder="Curso" maxlength="50" required>

        <label>Ano de Ingresso:</label>
        <input type="number" name="ano_ingresso" placeholder="Ano de Ingresso" min="2000" max="2100" required>

        <div id="responsaveis">
            <div class="responsavel">
                <label>Nome Responsável:</label>
                <input type="text" name="nomeResponsavel[]" placeholder="Nome do responsável" maxlength="100" required>

                <label>Contato Responsável:</label>
                <input type="text" name="contatoResponsavel[]" placeholder="Contato responsável" maxlength="15" required>

                <label>Parentesco:</label>
                <input type="text" name="parentescoResponsavel[]" placeholder="Parentesco" maxlength="10" required>
            </div>
        </div>

        <button type="button" onclick="adicionarResponsavel()">Adicionar Responsável</button>

        <br><br>
        <input type="submit" value="Cadastrar">
    </form>

    <br>
    <button onclick="window.location.href='index.php'">Voltar ao Menu</button>

    <script>
        function adicionarResponsavel() {
            var divResponsaveis = document.getElementById("responsaveis");
            var novoResponsavel = document.createElement("div");
            novoResponsavel.classList.add("responsavel");
            novoResponsavel.innerHTML = `
                <label>Nome Responsável:</label>
                <input type="text" name="nomeResponsavel[]" placeholder="Nome do responsável" maxlength="100" required>

                <label>Contato Responsável:</label>
                <input type="text" name="contatoResponsavel[]" placeholder="Contato responsável" maxlength="15" required>

                <label>Parentesco:</label>
                <input type="text" name="parentescoResponsavel[]" placeholder="Parentesco" maxlength="10" required>

                <button type="button" onclick="removerResponsavel(this)">Remover</button>
            `;

            divResponsaveis.appendChild(novoResponsavel);
        }

        function removerResponsavel(botao) {
            botao.parentNode.remove();
        }
    </script>
</body>
</html>


