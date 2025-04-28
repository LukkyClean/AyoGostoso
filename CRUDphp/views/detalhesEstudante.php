<?php
    // Inclui o controlador e instancia a classe Controller
    require_once 'controllers/Controller.php';
    $controller = new Controller();

    // Coleta os dados passados via GET e define variáveis
    $matriculaEstudante = isset($_GET['matricula']) ? $_GET['matricula'] : '';
    $nomeEstudante = isset($_GET['nome']) ? $_GET['nome'] : '';
    $cursoEstudante = isset($_GET['curso']) ? $_GET['curso'] : '';
    $anoIngressoEstudante = isset($_GET['anoIngresso']) ? $_GET['anoIngresso'] : '';
    if ((date('Y') - $anoIngressoEstudante) > 2) {
        $serieEstudante = "Finalizado";
    } else {
        $serieEstudante = ((date('Y') - $anoIngressoEstudante) + 1) . "º Ano";
    }
    $idEstudante = isset($_GET['id']) ? $_GET['id'] : '';

    // Lista os responsáveis pelo estudante
    $responsaveis = $controller->listarResponsaveis($idEstudante);

    $opcoesSerie = [
        "1º Ano",
        "2º Ano",
        "3º Ano",
        "Finalizado"
    ];

    $opcoesCurso = [
        "Administração",
        "Desenvolvimento de Sistemas",
        "Enfermagem",
        "Informática"
    ];

    $opcoesParentesco = [
        "Pai",
        "Mãe",
        "Avós",
        "Tios",
        "Irmãos"
    ];
    
    $contResponsavel = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Estudante</title>

    <!-- CSS customizado -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <!-- Header com navbar -->
    <header class="navbar">
        <nav class="navbar fixed-top" style="background-color: #57AB48;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./images/LogoAmelia.png" alt="Logo Amélia" width="113px" height="70px">
                </a>

                <!-- Botão do menu (offcanvas) -->
                <button class="navbar-toggler" style="color: white; border: 0;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <img src="./images/MenuIcon.png" alt="Menu" width="40px" height="40px">
                </button>

                <!-- Menu lateral -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">EEEP Amélia Figueiredo de Lavor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Listar Estudantes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Cadastrar Estudantes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <main>
        <section class="data">

            <!-- Dados do estudante -->
            <div class="student">
                <h1>Dados do Aluno</h1>

                <!-- VISUALIZAÇÃO -->
                <div class="box" id="view-student-box">
                    <div class="image">
                        <img src="./images/userImage.png" id="student-photo" class="rounded-circle" width="250px" height="250px">
                    </div>
                    <div class="description">
                        <div class="content">
                            <p>Matrícula: <span><?=htmlspecialchars($matriculaEstudante)?></span></p>
                            <p>Nome: <span><?=htmlspecialchars($nomeEstudante)?></span></p>
                            <p>Série: <span><?=htmlspecialchars($serieEstudante)?></span></p>
                            <p>Curso: <span><?=htmlspecialchars($cursoEstudante)?></span></p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="icon" onclick="abrirEdicaoEstudante()"><img src="./images/EditStudent.svg" alt="Ícone de editar" width="50px" height="50px" style="transform: scale(1.16);"></button>
                        <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#excludeStudent"><img src="./images/DeleteStudent.svg" alt="Ícone de excluir" width="50px" height="50px"></button>
                        <!-- Modal -->
                        <div class="modal fade" id="excludeStudent" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Excluir Estudante</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        Você tem certeza que deseja excluir este item?
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" onclick="" class="btn btn-outline-danger" >Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EDIÇÃO -->
                <div class="box" id="edit-student-box" style="display: none;">
                    <div class="image">
                        <div class="profile" >
                            <label for="fileInput">
                                <img class="pic-user" id="preview" src="./images/userImage.png" alt="Foto do usuario">
                                <img class="pic-edit" src="./images/edit-circle.svg" data-bs-toggle="tooltip" title="Adicione uma nova foto" style="border-radius: 8px;">
                            </label>
                            <input type="file" class="file-input" id="fileInput" accept="image/*">
                        </div>
                    </div>
                    <div class="description">
                        <form id="studentForm" class="content" action="router.php?rota=editarEstudante" method="POST">
                            <input type="hidden" name="idEstudante" value="<?=htmlspecialchars($idEstudante)?>">
                            <div class="data-edit">
                                <label for="matricula-edit">Matrícula: </label>
                                <input type="text" id="matricula-edit" name="matriculaEstudante" value="<?=htmlspecialchars($matriculaEstudante)?>" placeholder="Digite a matrícula" minlength="8" maxlength="8" required>
                            </div>
                            <div class="data-edit">
                                <label for="nome-edit">Nome: </label>
                                <input type="text" id="nome-edit" name="novoNomeEstudante" value="<?=htmlspecialchars($nomeEstudante)?>" placeholder="Digite um nome" maxlength="100" requird>
                            </div>
                            <div class="data-edit">
                                <label for="serie-edit">Série: </label>
                                <select id="serie-edit" name="serieEstudante">
                                    <option value="<?=htmlspecialchars($serieEstudante)?>" selected><?=htmlspecialchars($serieEstudante)?></option>
                                    <?php foreach ($opcoesSerie as $option): ?>
                                        <?php if ($serieEstudante !== $option ): ?>
                                            <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="data-edit">
                                <label for="curso-edit">Curso: </label>
                                <select id="curso-edit" name="cursoEstudante">
                                    <option value="<?=htmlspecialchars($cursoEstudante)?>" selected><?=htmlspecialchars($cursoEstudante)?></option>
                                        <?php foreach ($opcoesCurso as $option): ?>
                                            <?php if ($cursoEstudante !== $option ): ?>
                                                <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="actions">
                        <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#confirmStudentEdit"><img src="./images/Confirm.png" alt="Ícone de salvar" width="50px" height="50px"></button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmStudentEdit" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Editar Aluno</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        Você tem certeza que deseja editar este item?
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" form="studentForm" class="btn btn-outline-success" >Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="icon" onclick="cancelarEdicaoEstudante()"><img src="./images/Cancel.png" alt="Ícone de cancelar" width="50px" height="50px"></button>
                    </div>
                </div>
            </div>


            <!-- Responsáveis cadastrados -->
            <div class="parent">
                <h1>Responsáveis Cadastrados</h1>
                <div id="responsaveis">
                    <?php foreach ($responsaveis as $responsavel): ?>
                        <div style="display: none;"><?= $contResponsavel += 1 ?></div>
                        <div class="responsavel">
                            <!-- VISUALIZAÇÃO -->
                            <div class="box" id="view-parent-box<?=$contResponsavel?>">
                                <div class="image">
                                    <img src="./images/qr_code.png" class="rounded" alt="QR code do contato" width="250px" height="250px">
                                </div>
                                <div class="description">
                                    <div class="content">
                                        <p>Contato: <span id="cell-parent-format"><?=htmlspecialchars($responsavel->contato)?></span></p>
                                        <p>Nome: <span><?=htmlspecialchars($responsavel->nome)?></span></p>
                                        <p>Parentesco: <span><?=htmlspecialchars($responsavel->parentesco)?></span></p>
                                        <p>Link do Whatsapp: <span><a href="https://wa.me/<?=htmlspecialchars($responsavel->contato)?>">Clique aqui</a></span></p>
                                    </div>
                                </div>
                                <div class="actions">
                                    <button class="icon" onclick="abrirEdicaoResponsavel(<?=$contResponsavel?>)"><img src="./images/EditStudent.svg" alt="Ícone de editar" width="50px" height="50px" style="transform: scale(1.16);"></button>
                                    <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#excludeParent"><img src="./images/DeleteStudent.svg" alt="Ícone de excluir" width="50px" height="50px"></button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="excludeParent" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModalLabel">Excluir Responsável</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    Você tem certeza que deseja excluir este item?
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" onclick="" class="btn btn-outline-danger" >Confirmar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- EDIÇÃO -->
                            <div class="box" id="edit-parent-box<?=$contResponsavel?>" style="display: none;">
                                <div class="image">
                                    <img src="./images/qr_code.png" class="rounded" width="250px" height="250px">
                                </div>
                                <div class="description">
                                    <form id="parentForm<?=$contResponsavel?>" class="content" action="router.php?rota=editarResponsavel" method="POST">
                                        <input type="hidden" name="idEstudante" value="<?=htmlspecialchars($idEstudante)?>">
                                        <input type="hidden" name="oldNameParent" value="<?=htmlspecialchars($responsavel->nome)?>">
                                        <div class="data-edit">
                                            <label for="cell-parent-edit">Contato: </label>
                                            <input type="text" id="cell-parent-edit" name="contactParent" value="<?=htmlspecialchars($responsavel->contato)?>" placeholder="(88) 99999-9999" minlength="15" maxlength="15" required>
                                        </div>
                                        <div class="data-edit">
                                            <label for="name-parent-edit">Nome: </label>
                                            <input type="text" id="name-parent-edit" name="newNameParent" value="<?=htmlspecialchars($responsavel->nome)?>" placeholder="Digite um nome" maxlength="100" required>
                                        </div>
                                        <div class="data-edit">
                                            <label for="serie-edit">Parentesco: </label>
                                            <select id="parentesco-edit" name="kinshipParent">
                                                <option value="<?=htmlspecialchars($responsavel->parentesco)?>" selected><?=htmlspecialchars($responsavel->parentesco)?></option>
                                                <?php foreach ($opcoesParentesco as $option): ?>
                                                    <?php if ($responsavel->parentesco !== $option ): ?>
                                                        <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="actions">
                                    <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#confirmParentEdit<?=$contResponsavel?>"><img src="./images/Confirm.png" alt="Ícone de salvar" width="50px" height="50px"></button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="confirmParentEdit<?=$contResponsavel?>" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModalLabel">Editar Responsável</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    Você tem certeza que deseja editar este item?
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" form="parentForm<?=$contResponsavel?>" class="btn btn-outline-success" >Confirmar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="icon" onclick="cancelarEdicaoResponsavel(<?=$contResponsavel?>)"><img src="./images/Cancel.png" alt="Ícone de cancelar" width="50px" height="50px"></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Botão para adicionar novo responsável -->
                <button class="add-parent icon" id="add-parent" onclick="adicionarResponsavel()">
                    <img src="./images/addParent.png" alt="Adicionar um responsável" width="50px" height="50px">
                </button>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer>
        <div class="bg-footer-img"></div>
    </footer>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <script>
        function abrirEdicaoEstudante() {
            document.getElementById('view-student-box').style.display = 'none';
            document.getElementById('edit-student-box').style.display = 'flex';
        }

        function cancelarEdicaoEstudante() {
            document.getElementById('edit-student-box').style.display = 'none';
            document.getElementById('view-student-box').style.display = 'flex';
        }

        function abrirEdicaoResponsavel(responsavel) {
            document.getElementById(`view-parent-box${responsavel}`).style.display = 'none';
            document.getElementById(`edit-parent-box${responsavel}`).style.display = 'flex';
        }

        function cancelarEdicaoResponsavel(responsavel) {
            document.getElementById(`edit-parent-box${responsavel}`).style.display = 'none';
            document.getElementById(`view-parent-box${responsavel}`).style.display = 'flex';
        }

        const fileInput = document.getElementById('fileInput');
        const previewImg = document.getElementById('preview');

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        window.onload = function () {
            const span = document.getElementById('cell-parent-format');
            const numero = span.innerText.replace(/\D/g, ''); // remove tudo que não for dígito
   
            if (numero.length === 11) {
                const ddd = numero.slice(0, 2);
                const parte1 = numero.slice(2, 7);
                const parte2 = numero.slice(7, 11);
                span.innerText = `(${ddd}) ${parte1}-${parte2}`;
            }
        }

        function formatarTelefone(valor) {
            const numeros = valor.replace(/\D/g, '').slice(0, 11); // só dígitos, máximo 11

            if (numeros.length === 0) return '';

            if (numeros.length <= 2) return `(${numeros}`;
            if (numeros.length <= 6) return `(${numeros.slice(0, 2)}) ${numeros.slice(2)}`;
            if (numeros.length <= 10) return `(${numeros.slice(0, 2)}) ${numeros.slice(2, 6)}-${numeros.slice(6)}`;
            return `(${numeros.slice(0, 2)}) ${numeros.slice(2, 7)}-${numeros.slice(7)}`;
        }

        const input = document.getElementById('cell-parent-edit');

        input.addEventListener('input', function (e) {
            const cursorAntes = e.target.selectionStart;
            const valorOriginal = e.target.value;
            const numeros = valorOriginal.replace(/\D/g, '');

            const valorFormatado = formatarTelefone(valorOriginal);

            e.target.value = valorFormatado;

            // Calcular nova posição do cursor
            const diff = valorFormatado.length - valorOriginal.length;

            let novaPos = cursorAntes + diff;
                if (diff > 0 && valorOriginal[cursorAntes - 1]?.match(/\D/)) {
                novaPos += 1; // se apagou um caractere especial, avança 1
            }

            setTimeout(() => {
                e.target.setSelectionRange(novaPos, novaPos);
            }, 0);
        });

        // Aplica formatação inicial ao carregar
        window.addEventListener('DOMContentLoaded', () => {
            input.value = formatarTelefone(input.value);
        });

        function adicionarResponsavel() {
            document.getElementById('add-parent').style.display = 'none';

            var divResponsaveis = document.getElementById("responsaveis");
            var novoResponsavel = document.createElement("div");
            novoResponsavel.classList.add("responsavel");
            novoResponsavel.innerHTML = `
                <!-- ADICIONAR -->
                <div class="box" id="edit-parent-box">
                    <div class="image">
                        <img src="./images/qr_code.png" class="rounded" width="250px" height="250px">
                    </div>
                    <div class="description">
                        <form id="parentForm1" class="content">
                            <div class="data-edit">
                                <label for="contato-edit">Contato: </label>
                                <input type="text" id="cell-parent-edit" value="" placeholder="(88) 99999-9999" minlength="15" maxlength="15" required>
                            </div>
                            <div class="data-edit">
                                <label for="nome-edit">Nome: </label>
                                <input type="text" id="name-parent-edit" value="" placeholder="Digite um nome" maxlength="100" required>
                            </div>
                            <div class="data-edit">
                                <label for="serie-edit">Parentesco: </label>
                                <select id="parentesco-edit">
                                    <option value="" disabled selected hidden>-- Selecione uma opção --</option>
                                    <option value="pai">Pai</option>
                                    <option value="mae">Mãe</option>
                                    <option value="irmao">Irmãos</option>
                                    <option value="avo">Avós</option>
                                    <option value="tio">Tios</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="actions">
                        <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#confirmParentEdit1"><img src="./images/Confirm.png" alt="Ícone de salvar" width="50px" height="50px"></button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmParentEdit1" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Adicionar Responsável</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        Você tem certeza que deseja adicionar este item?
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" form="parentForm1" class="btn btn-outline-success" >Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="icon" onclick="removerResponsavel(this)"><img src="./images/Cancel.png" alt="Ícone de cancelar" width="50px" height="50px"></button>
                    </div>
                </div>
            `;

            divResponsaveis.appendChild(novoResponsavel);
        }

        function removerResponsavel(botao) {
            if (confirm("Deseja realmente cancelar esse responsável?")) {
                document.getElementById('add-parent').style.display = 'flex';
                var responsavelDiv = botao.closest(".responsavel");
                responsavelDiv.remove();
            }
        }

    </script>
</body>
</html>
