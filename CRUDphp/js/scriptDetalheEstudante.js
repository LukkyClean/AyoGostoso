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


function formatarTelefone(valor) {
    valor = valor.replace(/\D/g, ""); // Remove não dígitos
    if (valor.length > 11) valor = valor.slice(0, 11);
  
    if (valor.length > 10) {
      valor = valor.replace(/(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (valor.length > 6) {
      valor = valor.replace(/(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (valor.length > 2) {
      valor = valor.replace(/(\d{2})(\d{0,5})/, "($1) $2");
    } else {
      valor = valor.replace(/(\d{0,2})/, "$1");
    }
  
    return valor;
  }
  
  function aplicarMascaraTelefone(element) {
    // Aplica máscara ao carregar
    if (element.tagName === "INPUT") {
        valor = element.value;
        element.value = formatarTelefone(valor);
    
        // Aplica a máscara também enquanto digita (opcional)
        element.addEventListener("input", function (e) {
          e.target.value = formatarTelefone(e.target.value);
        });
    } else {
        element.textContent = formatarTelefone(element.textContent);
    }
  }

// Remover responsável
function removerResponsavel(botao) {
        document.getElementById('add-parent').style.display = 'flex';
        var responsavelDiv = botao.closest(".responsavel");
        responsavelDiv.remove();
}
