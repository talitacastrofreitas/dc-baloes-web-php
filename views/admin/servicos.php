<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Gerenciar Serviços</h2>
    
    <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
        <form action="index.php?url=admin/salvar-servico" method="POST">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label class="form-label small">Nome do Serviço</label>
                    <input type="text" name="service_name" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label small">Valor Mínimo</label>
                    <input type="text" name="min_value" class="form-control" required>
                </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="service_description" id="service_description" class="form-control" rows="3"></textarea>
                    </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Serviço</th>
                    <th>Valor Mínimo</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicos as $s): ?>
                <tr>
                    <td class="ps-4 fw-bold"><?= htmlspecialchars($s['service_name']) ?></td>
                    <td>R$ <?= number_format($s['min_value'], 2, ',', '.') ?></td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick='editarServico(<?= json_encode($s) ?>)'><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="confirmarExclusao(<?= $s['id'] ?>)"> <i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalEditarServico" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Editar Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?url=admin/atualizar-servico" method="POST">
                <input type="hidden" name="id" id="edit_service_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome do Serviço</label>
                        <input type="text" name="service_name" id="edit_service_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Valor Mínimo</label>
                        <input type="text" name="min_value" id="edit_min_value" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="service_description" id="edit_service_description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editarServico(data) {
    // Agora os IDs existem no HTML acima!
    document.getElementById('edit_service_id').value = data.id;
    document.getElementById('edit_service_name').value = data.service_name;
    document.getElementById('edit_min_value').value = data.min_value;
    document.getElementById('edit_service_description').value = data.service_description || '';

    var editModal = new bootstrap.Modal(document.getElementById('modalEditarServico'));
    editModal.show();
}

function confirmarExclusao(id) {
    Swal.fire({
        title: 'Excluir serviço?',
        text: "Isso pode afetar os produtos vinculados!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e64a85',
        confirmButtonText: 'Sim, excluir'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `index.php?url=admin/excluir-servico&id=${id}`;
        }
    });
}
</script>

<?php include(__DIR__ . '/../partials/footer.php'); ?>