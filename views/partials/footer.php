</main>

<footer class="mt-5 border-top bg-white">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start mb-4 mb-md-0">
                <h6 class="fw-bold mb-1">Créditos de Desenvolvimento</h6>
                <div class="small text-muted">
                    <span class="fw-semibold text-dark">Desenvolvedora:</span> Talita Castro Freitas<br>
                    Analista de Desenvolvimento de Software<br>
                    <span class="text-secondary">Graduação em Análise e Desenvolvimento de Sistemas | Pós-graduação em Engenharia de Software</span>
                </div>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <a href="index.php?url=login" class="btn btn-outline-pink btn-sm rounded-pill px-4 shadow-sm" style="border-color: #fce4ec; color: #ad1457; font-size: 0.85rem;">
                    🔒 Acesso Administrativo
                </a>
            </div>
        </div>

        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted">&copy; <?php echo date('Y'); ?> 🎈 DCBalões - Todos os direitos reservados.</small>
        </div>
    </div>
</footer>

<script>
    function confirmarExclusaoGeral(url) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Esta ação não pode ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e64a85',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('sucesso')) {
        showToast("Operação realizada com sucesso!");
    }
    
    if (urlParams.has('excluido')) {
        showToast("Registro removido permanentemente.", "error");
    }
    
    if (urlParams.has('atualizado')) {
        showToast("Informações atualizadas!");
    }

    if (urlParams.has('envio')) {
        showToast("Código enviado para o seu e-mail!", "success");
    }

    if (urlParams.has('erro_email')) {
        showToast("Erro ao enviar e-mail. Verifique as configurações.", "error");
    }

    if (urlParams.has('erro') && urlParams.get('url') === 'esqueci-senha') {
        showToast("E-mail não cadastrado no sistema.", "error");
    }

    if (urlParams.has('senha_resetada')) {
    showToast("Senha alterada com sucesso! Faça login com a nova senha.", "success");
}

    if (urlParams.has('erro=token_invalido')) {
    showToast("Senha não alterada.", "error");
}
  
    if (urlParams.has('erro_login')) {
    showToast("E-mail ou senha incorretos. Tente novamente.", "error");
}

   if (urlParams.has('erro_codigo')) {
    showToast("Código incorreto ou expirado.", "error");
}

if (urlParams.has('sucesso_exclusao')) {
    showToast("Usuário removido com sucesso!", "success");
}

});
</script>

<script>
// Função para aplicar a máscara de telefone (formato Brasil)
function mascaraTelefone(event) {
    let input = event.target;
    let value = input.value.replace(/\D/g, ""); // Remove tudo que não é número
    
    // Limita a 11 dígitos
    if (value.length > 11) value = value.slice(0, 11);

    if (value.length > 10) {
        // Formato Celular: (99) 99999-9999
        value = value.replace(/^(\22)(\d{5})(\d{4}).*/, "($1) $2-$3");
        // Ajuste manual para maior precisão durante a digitação:
        input.value = value.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
    } else if (value.length > 5) {
        input.value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
    } else if (value.length > 2) {
        input.value = value.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
    } else {
        input.value = value;
    }
}

// Aplica a máscara em todos os campos com a classe 'mask-phone'
document.addEventListener("DOMContentLoaded", function() {
    const phones = document.querySelectorAll('.mask-phone');
    phones.forEach(p => {
        p.addEventListener('input', mascaraTelefone);
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Verifica se existem parâmetros de mensagem na URL
    const url = new URL(window.location);
    // Adicionado 'sucesso_exclusao' e 'erro_codigo' à lista para limpeza
    const paramsParaLimpar = ['sucesso', 'erro', 'excluido', 'atualizado', 'sucesso_exclusao', 'erro_codigo'];
    
    let encontrouParametro = false;

    // Disparar o Toastify antes de limpar a URL (caso ainda não tenha feito em outro bloco)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('sucesso_exclusao')) {
        showToast("Usuário removido com sucesso!", "success");
    }

    paramsParaLimpar.forEach(param => {
        if (url.searchParams.has(param)) {
            encontrouParametro = true;
            url.searchParams.delete(param); // Remove o parâmetro do objeto URL
        }
    });

    // 2. Se encontrou algo, limpa a barra de endereços de forma "silenciosa"
    if (encontrouParametro) {
        // Isso remove os parâmetros da barra sem dar refresh na página
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
});
</script>