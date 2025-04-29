<?php
    require_once 'controllers/Controller.php';
    $controller = new Controller();

    $matriculaEstudante = $_GET['matricula'] ?? '';
    $nomeEstudante = $_GET['nome'] ?? '';
    $cursoEstudante = $_GET['curso'] ?? '';
    $anoIngressoEstudante = $_GET['anoIngresso'] ?? '';
    $idEstudante = $_GET['id'] ?? '';

    $serieEstudante = (is_numeric($anoIngressoEstudante) &&((date('Y') - (int)$anoIngressoEstudante) > 2)) 
        ? "Finalizado" 
        : ((date('Y') - (int)$anoIngressoEstudante) + 1) . "º Ano";

    $responsaveis = $controller->listarResponsaveis($idEstudante);

    $opcoesSerie = ["1º Ano", "2º Ano", "3º Ano", "Finalizado"];
    $opcoesCurso = ["Administração", "Desenvolvimento de Sistemas", "Enfermagem", "Informática"];
    $opcoesParentesco = ["Pai", "Mãe", "Avós", "Tios", "Irmãos"];

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

        <!-- ===================== DADOS DO ALUNO ===================== -->
        <div class="student">
            <h1>Dados do Aluno</h1>

            <!-- VISUALIZAÇÃO DO ALUNO -->
            <div class="box" id="view-student-box">
                <div class="image">
                    <img src="./images/userImage.png" id="student-photo" class="rounded-circle" width="250px" height="250px">
                </div>
                <div class="description">
                    <div class="content">
                        <p>Matrícula: <span><?= htmlspecialchars($matriculaEstudante) ?></span></p>
                        <p>Nome: <span><?= htmlspecialchars($nomeEstudante) ?></span></p>
                        <p>Série: <span><?= htmlspecialchars($serieEstudante) ?></span></p>
                        <p>Curso: <span><?= htmlspecialchars($cursoEstudante) ?></span></p>
                    </div>
                </div>
                <div class="actions">
                    <!-- Botão de edição -->
                    <button class="icon" onclick="abrirEdicaoEstudante()">
                        <img src="./images/EditStudent.svg" alt="Ícone de editar" width="50px" height="50px" style="transform: scale(1.16);">
                    </button>

                    <!-- Botão de exclusão -->
                    <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#excludeStudent">
                        <img src="./images/DeleteStudent.svg" alt="Ícone de excluir" width="50px" height="50px">
                    </button>

                    <!-- Modal de confirmação de exclusão -->
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
                                    <button type="button" onclick="window.location.href='router.php?rota=confirmarDeletar&tipo=estudante&id=<?= htmlspecialchars($idEstudante) ?>'" class="btn btn-outline-danger">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EDIÇÃO DO ALUNO -->
            <div class="box" id="edit-student-box" style="display: none;">
                <div class="image">
                    <div class="profile">
                        <label for="fileInput">
                            <img class="pic-user" id="preview" src="./images/userImage.png" alt="Foto do usuário">
                            <img class="pic-edit" src="./images/edit-circle.svg" data-bs-toggle="tooltip" title="Adicione uma nova foto" style="border-radius: 8px;">
                        </label>
                        <input type="file" class="file-input" id="fileInput" accept="image/*">
                    </div>
                </div>
                <div class="description">
                    <form id="studentForm" class="content" action="router.php?rota=editarEstudante" method="POST">
                        <input type="hidden" name="idEstudante" value="<?= htmlspecialchars($idEstudante) ?>">

                        <div class="data-edit">
                            <label for="matricula-edit">Matrícula:</label>
                            <input type="text" id="matricula-edit" name="matriculaEstudante" value="<?= htmlspecialchars($matriculaEstudante) ?>" minlength="8" maxlength="8" required>
                        </div>

                        <div class="data-edit">
                            <label for="nome-edit">Nome:</label>
                            <input type="text" id="nome-edit" name="novoNomeEstudante" value="<?= htmlspecialchars($nomeEstudante) ?>" maxlength="100" required>
                        </div>

                        <div class="data-edit">
                            <label for="serie-edit">Série:</label>
                            <select id="serie-edit" name="serieEstudante">
                                <option value="<?= htmlspecialchars($serieEstudante) ?>" selected><?= htmlspecialchars($serieEstudante) ?></option>
                                <?php foreach ($opcoesSerie as $option): ?>
                                    <?php if ($serieEstudante !== $option): ?>
                                        <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="data-edit">
                            <label for="curso-edit">Curso:</label>
                            <select id="curso-edit" name="cursoEstudante">
                                <option value="<?= htmlspecialchars($cursoEstudante) ?>" selected><?= htmlspecialchars($cursoEstudante) ?></option>
                                <?php foreach ($opcoesCurso as $option): ?>
                                    <?php if ($cursoEstudante !== $option): ?>
                                        <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="actions">
                    <!-- Botão salvar edição -->
                    <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#confirmStudentEdit">
                        <img src="./images/Confirm.png" alt="Ícone de salvar" width="50px" height="50px">
                    </button>

                    <!-- Modal de confirmação de edição -->
                    <div class="modal fade" id="confirmStudentEdit" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Aluno</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">Você tem certeza que deseja editar este item?</div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="studentForm" class="btn btn-outline-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botão cancelar edição -->
                    <button class="icon" onclick="cancelarEdicaoEstudante()">
                        <img src="./images/Cancel.png" alt="Ícone de cancelar" width="50px" height="50px">
                    </button>
                </div>
            </div>
        </div>

        <!-- ===================== RESPONSÁVEIS ===================== -->
        <div class="parent">
            <h1>Responsáveis Cadastrados</h1>
            <div id="responsaveis">
                <?php foreach ($responsaveis as $responsavel): ?>
                    <div style="display: none;"><?= $contResponsavel += 1 ?></div>
                    <div class="responsavel">

                        <!-- VISUALIZAÇÃO DO RESPONSÁVEL -->
                        <div class="box" id="view-parent-box<?= $contResponsavel ?>">
                            <div class="image">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://wa.me/<?= htmlspecialchars($responsavel->contato) ?>" alt="QR code do contato" class="rounded" width="250px" height="250px">
                            </div>
                            <div class="description">
                                <div class="content">
                                    <p>Contato: <span class="contact"><?= htmlspecialchars($responsavel->contato) ?></span></p>
                                    <p>Nome: <span><?= htmlspecialchars($responsavel->nome) ?></span></p>
                                    <p>Parentesco: <span><?= htmlspecialchars($responsavel->parentesco) ?></span></p>
                                    <p>Link do Whatsapp: <span><a href="https://wa.me/<?= htmlspecialchars($responsavel->contato) ?>">Clique aqui</a></span></p>
                                </div>
                            </div>
                            <div class="actions">
                                <!-- Botão editar -->
                                <button class="icon" onclick="abrirEdicaoResponsavel(<?= $contResponsavel ?>)">
                                    <img src="./images/EditStudent.svg" alt="Ícone de editar" width="50px" height="50px" style="transform: scale(1.16);">
                                </button>

                                <!-- Botão excluir -->
                                <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#excludeParent<?= $contResponsavel ?>">
                                    <img src="./images/DeleteStudent.svg" alt="Ícone de excluir" width="50px" height="50px">
                                </button>

                                <!-- Modal confirmação exclusão -->
                                <div class="modal fade" id="excludeParent<?= $contResponsavel ?>" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir Responsável</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body">Você tem certeza que deseja excluir este item?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" onclick="window.location.href='router.php?rota=confirmarDeletar&tipo=responsavel&id=<?= htmlspecialchars($responsavel->id) ?>'" class="btn btn-outline-danger">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- EDIÇÃO DO RESPONSÁVEL -->
                        <div class="box" id="edit-parent-box<?= $contResponsavel ?>" style="display: none;">
                            <div class="image">
                                <img src="./images/qr_code.png" class="rounded" width="250px" height="250px">
                            </div>
                            <div class="description">
                                <form id="parentForm<?= $contResponsavel ?>" class="content" action="router.php?rota=editarResponsavel" method="POST">
                                    <input type="hidden" name="idEstudante" value="<?= htmlspecialchars($idEstudante) ?>">
                                    <input type="hidden" name="oldNameParent" value="<?= htmlspecialchars($responsavel->nome) ?>">

                                    <div class="data-edit">
                                        <label for="cell-parent-edit">Contato:</label>
                                        <input class="contact" type="text" name="contactParent" value="<?= htmlspecialchars($responsavel->contato) ?>" minlength="15" maxlength="15" required>
                                    </div>

                                    <div class="data-edit">
                                        <label for="name-parent-edit">Nome:</label>
                                        <input type="text" name="newNameParent" value="<?= htmlspecialchars($responsavel->nome) ?>" maxlength="100" required>
                                    </div>

                                    <div class="data-edit">
                                        <label for="parentesco-edit">Parentesco:</label>
                                        <select name="kinshipParent">
                                            <option value="<?= htmlspecialchars($responsavel->parentesco) ?>" selected><?= htmlspecialchars($responsavel->parentesco) ?></option>
                                            <?php foreach ($opcoesParentesco as $option): ?>
                                                <?php if ($responsavel->parentesco !== $option): ?>
                                                    <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="actions">
                                <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#confirmParentEdit<?= $contResponsavel ?>">
                                    <img src="./images/Confirm.png" alt="Ícone de salvar" width="50px" height="50px">
                                </button>

                                <!-- Modal confirmação edição -->
                                <div class="modal fade" id="confirmParentEdit<?= $contResponsavel ?>" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Responsável</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body">Você tem certeza que deseja editar este item?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" form="parentForm<?= $contResponsavel ?>" class="btn btn-outline-success">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cancelar edição -->
                                <button class="icon" onclick="cancelarEdicaoResponsavel(<?= $contResponsavel ?>)">
                                    <img src="./images/Cancel.png" alt="Ícone de cancelar" width="50px" height="50px">
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Botão para adicionar novo responsável -->
            <?php if ($contResponsavel < 2): ?>
                <button class="add-parent icon" id="add-parent" onclick="adicionarResponsavel()">
                    <img src="./images/addParent.png" alt="Adicionar um responsável" width="50px" height="50px">
                </button>
            <?php endif; ?>
        </div>
    </section>
</main>

    <!-- Rodapé -->
    <footer>
        <div class="bg-footer-img"></div>
    </footer>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <script src="./js/scriptDetalheEstudante.js"></script>
</body>
</html>
