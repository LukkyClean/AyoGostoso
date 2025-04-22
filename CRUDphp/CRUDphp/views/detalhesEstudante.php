<?php
    // Inclui o controlador e instancia a classe Controller
    require_once 'controllers/Controller.php';
    $controller = new Controller();

    // Coleta os dados passados via GET e define variáveis
    $matriculaEstudante = isset($_GET['matricula']) ? $_GET['matricula'] : '';
    $nomeEstudante = isset($_GET['nome']) ? $_GET['nome'] : '';
    $cursoEstudante = isset($_GET['curso']) ? $_GET['curso'] : '';
    $anoIngressoEstudante = isset($_GET['anoIngresso']) ? $_GET['anoIngresso'] : '';
    $idEstudante = isset($_GET['id']) ? $_GET['id'] : '';

    // Lista os responsáveis pelo estudante
    $responsaveis = $controller->listarResponsaveis($idEstudante);
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
                            <p>Matrícula: <span id="matricula-view">15878969</span></p>
                            <p>Nome: <span id="nome-view">Carlos André Guedes de Almeida</span></p>
                            <p>Série: <span id="serie-view">3º ano</span></p>
                            <p>Curso: <span id="curso-view">Informática</span></p>
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
                        <form id="studentForm" class="content">
                            <div class="data-edit">
                                <label for="matricula-edit">Matrícula: </label>
                                <input type="text" id="matricula-edit" value="15878969" placeholder="99999999" minlength="8" maxlength="8" required>
                            </div>
                            <div class="data-edit">
                                <label for="nome-edit">Nome: </label>
                                <input type="text" id="nome-edit" value="Carlos André Guedes de Almeida" placeholder="Digite um nome" maxlength="100" requird>
                            </div>
                            <div class="data-edit">
                                <label for="serie-edit">Série: </label>
                                <select id="serie-edit">
                                    <option value="3">3° Ano</option>
                                    <option value="1">1° Ano</option>
                                    <option value="2">2° Ano</option>
                                    <option value="0">Finalizado</option>
                                </select>
                            </div>
                            <div class="data-edit">
                                <label for="curso-edit">Curso: </label>
                                <select id="curso-edit">
                                    <option value="Informática">Informática</option>
                                    <option value="Administração">Administração</option>
                                    <option value="Desenvolvimento de Sistemas">Desenvolvimento de Sistemas</option>
                                    <option value="Enfermagem">Enfermagem</option>
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
                    <div class="responsavel">
                        <!-- VISUALIZAÇÃO -->
                        <div class="box" id="view-parent-box">
                            <div class="image">
                                <img src="./images/qr_code.png" class="rounded" alt="QR code do contato" width="250px" height="250px">
                            </div>
                            <div class="description">
                                <div class="content">
                                    <p>Contato: <span>(88) 99908-3353</span></p>
                                    <p>Nome: <span>Marcos Pedrosa de Almeida Guedes</span></p>
                                    <p>Parentesco: <span>Pai</span></p>
                                    <p>Link do Whatsapp: <span><a href="">Clique aqui</a></span></p>
                                </div>
                            </div>
                            <div class="actions">
                                <button class="icon" onclick="abrirEdicaoResponsavel()"><img src="./images/EditStudent.svg" alt="Ícone de editar" width="50px" height="50px" style="transform: scale(1.16);"></button>
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
                        <div class="box" id="edit-parent-box" style="display: none;">
                            <div class="image">
                                <img src="./images/qr_code.png" class="rounded" width="250px" height="250px">
                            </div>
                            <div class="description">
                                <form id="parentForm" class="content">
                                    <div class="data-edit">
                                        <label for="contato-edit">Contato: </label>
                                        <input type="text" id="cell-parent-edit" value="(88) 99908-3353" placeholder="(88) 99999-9999" minlength="15" maxlength="15" required>
                                    </div>
                                    <div class="data-edit">
                                        <label for="nome-edit">Nome: </label>
                                        <input type="text" id="name-parent-edit" value="Marcos Pedrosa de Almeida Guedes" placeholder="Digite um nome" maxlength="100" required>
                                    </div>
                                    <div class="data-edit">
                                        <label for="serie-edit">Parentesco: </label>
                                        <select id="parentesco-edit">
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
                                <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#confirmParentEdit"><img src="./images/Confirm.png" alt="Ícone de salvar" width="50px" height="50px"></button>
                                <!-- Modal -->
                                <div class="modal fade" id="confirmParentEdit" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
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
                                                <button type="submit" form="parentForm" class="btn btn-outline-success" >Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="icon" onclick="cancelarEdicaoResponsavel()"><img src="./images/Cancel.png" alt="Ícone de cancelar" width="50px" height="50px"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botão para adicionar novo responsável -->
                <button class="add-parent icon" onclick="adicionarResponsavel()">
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

        function abrirEdicaoResponsavel() {
            document.getElementById('view-parent-box').style.display = 'none';
            document.getElementById('edit-parent-box').style.display = 'flex';
        }

        function cancelarEdicaoResponsavel() {
            document.getElementById('edit-parent-box').style.display = 'none';
            document.getElementById('view-parent-box').style.display = 'flex';
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

        document.getElementById('cell-parent-edit').addEventListener('input', function (e) {
            let x = e.target.value.replace(/\D/g, '').substring(0, 11); // remove tudo que não é dígito
            let formatted = '';

            if (x.length > 0) {
                formatted = '(' + x.substring(0, 2);
            }
            if (x.length >= 3) {
                formatted += ') ' + x.substring(2, 7);
            }
            if (x.length >= 8) {
                formatted += '-' + x.substring(7, 11);
            }

            e.target.value = formatted;
        });

        function adicionarResponsavel() {
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
                var responsavelDiv = botao.closest(".responsavel");
                responsavelDiv.remove();
            }
        }

    </script>
</body>
</html>
