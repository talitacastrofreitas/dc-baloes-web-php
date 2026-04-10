<?php 
include('verificar_admin.php'); 
include('header.php'); 
include('config.php'); 

if (isset($_POST['add_service'])) {
    $sql = "INSERT INTO Services (service_name, service_description, min_value) VALUES (?, ?, ?)";
    sqlsrv_query($conn, $sql, array($_POST['name'], $_POST['description'], $_POST['min_value']));
}
?>

<div class="container py-5">
    <h2 class="font-heading fw-bold mb-4">Gerenciar Serviços</h2>
    
    <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
        <form method="POST">
            <div class="mb-3">
                <label class="small">Nome do Serviço</label>
                <input type="text" name="name" class="form-control" required placeholder="Ex: Arranjos">
            </div>
            <div class="mb-3">
                <label class="small">Descrição Padrão</label>
                <textarea name="description" class="form-control" rows="2" placeholder="Esta descrição aparecerá na calculadora"></textarea>
            </div>
            <div class="mb-3">
                <label class="small">Valor Mínimo (A partir de R$)</label>
                <input type="number" step="0.01" name="min_value" class="form-control" required>
            </div>
            <button type="submit" name="add_service" class="btn btn-primary rounded-pill px-4">Cadastrar Serviço</button>
        </form>
    </div>

<div class="row">
    <?php 
    $res = sqlsrv_query($conn, "SELECT * FROM Services");
    while($s = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)): 
        // Garante que valores nulos sejam tratados como strings vazias ou números decimais
        $nome_servico = $s['service_name'] ?? '';
        $descricao_servico = $s['service_description'] ?? '';
        $valor_minimo = isset($s['min_value']) ? (float)$s['min_value'] : 0.00;
    ?>
    <div class="col-md-4 mb-3">
    <div class="card h-100 border-0 shadow-sm p-3">
        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($s['service_name'] ?? ''); ?></h5>
        <p class="text-muted small mb-2"><?php echo nl2br(htmlspecialchars($s['service_description'] ?? '')); ?></p>
        <div class="text-primary fw-bold mb-3">
            A partir de R$ <?php echo number_format((float)($s['min_value'] ?? 0), 2, ',', '.'); ?>
        </div>
        
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" 
        onclick='editarServico(<?php echo json_encode($s); ?>)'>
    Editar
</button>
            
            <button class="btn btn-sm btn-outline-danger rounded-pill px-3" 
                    onclick="confirmarExclusao(<?php echo $s['id']; ?>)">
                Excluir
            </button>
        </div>
    </div>
</div>
    <?php endwhile; ?>
</div>
</div>


<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Editar Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="acoes_servico.php" method="POST">
                <input type="hidden" name="id" id="edit_id_input">
                <!-- <h4 id="tituloForm" class="font-heading fw-bold mb-3">Novo Orçamento</h4> -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small">Nome do Serviço</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small">Descrição Padrão</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="small">Valor Mínimo (R$)</label>
                        <input type="number" step="0.01" name="min_value" id="edit_min" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="update_service" class="btn btn-primary w-100 rounded-pill">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function editarServico(data) {
    // Preenche o campo oculto 'id' para o acoes_servico.php saber qual editar
    document.getElementById('edit_id_input').value = data.id;
    
    // Altera o título do modal
    // document.getElementById('tituloForm').innerText = "Editar Serviço: " + data.service_name;

    // Preenche os campos do formulário no Modal
    document.getElementById('edit_name').value = data.service_name;
    document.getElementById('edit_description').value = data.service_description || '';
    document.getElementById('edit_min').value = data.min_value;

    // Abre o modal do Bootstrap
    var modalElement = document.getElementById('modalEditar');
    var modal = new bootstrap.Modal(modalElement);
    modal.show();
}

function confirmarExclusao(id) {
    Swal.fire({
        title: 'Excluir Serviço?',
        text: "Isso pode afetar orçamentos que dependem deste valor mínimo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e64a85',
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `acoes_servico.php?del=${id}`;
        }
    });
}
</script>