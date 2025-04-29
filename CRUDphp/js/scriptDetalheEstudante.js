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

// Preview da imagem ao selecionar arquivo
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

// Formatação de telefone na visualização ao carregar a página
window.onload = function () {
    const telefones = document.querySelectorAll(".contact");
    telefones.forEach(aplicarMascaraTelefone);
};

function aplicarMascaraTelefone(element) {
    element.addEventListener("input", function (e) {
        let valor = e.target.value.replace(/\D/g, "");

        if (valor.length > 11) valor = valor.slice(0, 11); // Limite de 11 dígitos

        if (valor.length > 10) {
            valor = valor.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (valor.length > 6) {
            valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (valor.length > 2) {
            valor = valor.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
        } else {
            valor = valor.replace(/^(\d*)/, "($1");
        }

        e.target.value = valor;
    });
}


// Adicionar responsável
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
                <form id="parentFormNewParent" class="content" action="router.php?rota=cadastrarResponsavel" method="POST">
                    <input type="hidden" name="idEstudante" value="<?=htmlspecialchars($idEstudante)?>">
                    <div class="data-edit">
                        <label for="contato-edit">Contato: </label>
                        <input type="text" id="cell-parent-edit" name="contatoResponsavel" value="" placeholder="(88) 99999-9999" minlength="15" maxlength="15" required>
                    </div>
                    <div class="data-edit">
                        <label for="nome-edit">Nome: </label>
                        <input type="text" id="name-parent-edit" name="nomeResponsavel" value="" placeholder="Digite um nome" maxlength="100" required>
                    </div>
                    <div class="data-edit">
                        <label for="serie-edit">Parentesco: </label>
                        <select id="parentesco-edit" name="parentescoResponsavel">
                            <option value="" disabled selected hidden>-- Selecione uma opção --</option>
                            <option value="Pai">Pai</option>
                            <option value="Mãe">Mãe</option>
                            <option value="Irmãos">Irmãos</option>
                            <option value="Avós">Avós</option>
                            <option value="Tios">Tios</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="actions">
                <button class="btn icon" type="button" data-bs-toggle="modal" data-bs-target="#confirmParentNew">
                    <img src="./images/Confirm.png" alt="Ícone de salvar" width="50px" height="50px">
                </button>
                
                <!-- Modal -->
                <div class="modal fade" id="confirmParentNew" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
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
                                <button type="submit" form="parentFormNewParent" class="btn btn-outline-success">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="icon" onclick="removerResponsavel(this)">
                    <img src="./images/Cancel.png" alt="Ícone de cancelar" width="50px" height="50px">
                </button>
            </div>
        </div>
    `;

    divResponsaveis.appendChild(novoResponsavel);
}

// Remover responsável
function removerResponsavel(botao) {
        document.getElementById('add-parent').style.display = 'flex';
        var responsavelDiv = botao.closest(".responsavel");
        responsavelDiv.remove();
}
