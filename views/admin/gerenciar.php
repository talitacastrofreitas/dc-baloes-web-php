<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Gestão de Catálogo</h2>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalNovo">
            + Novo Produto
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive p-3">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Preço Base</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $lista_modals = ""; 
                    foreach ($produtos as $row): 
                        $prod_id = $row['id'];
                        $preco_base = $row['min_value'] ?? 0;
                    ?>
                        <tr>
                            <td><div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div></td>
                            <td><span class="badge bg-light text-dark"><?= htmlspecialchars($row['category']) ?></span></td>
                            <td><div class="text-primary fw-bold">R$ <?= number_format($preco_base, 2, ',', '.') ?></div></td>
                            <td class="text-end">
                                <button class="btn btn-link text-primary p-0 me-2" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $prod_id ?>">
                                   <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                           <a href="javascript:void(0)" 
   onclick="confirmarExclusaoGeral('index.php?url=admin/excluir-produto&id=<?= $prod_id ?>')" 
   class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>

                        <?php
                        // Captura o HTML do modal de edição para renderizar fora da tabela
                        ob_start();
                        ?>
                        <div class="modal fade" id="modalEditar<?= $prod_id ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Editar Produto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="index.php?url=admin/atualizar-produto" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $prod_id ?>">
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label small">Nome do Produto</label>
                                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Categoria</label>
                                                <select name="category" class="form-select">
                                                    <?php foreach ($categorias as $cat): ?>
                                                        <option value="<?= htmlspecialchars($cat['service_name']) ?>" <?= ($cat['service_name'] == $row['category']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($cat['service_name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Status</label>
                                                <select name="is_active" class="form-select">
                                                    <option value="1" <?= $row['is_active'] ? 'selected' : '' ?>>Ativo (Visível)</option>
                                                    <option value="0" <?= !$row['is_active'] ? 'selected' : '' ?>>Inativo (Oculto)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Descrição</label>
                                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($row['description'] ?? '') ?></textarea>
                                            </div>
                                     <div class="mb-3">
    <label class="form-label small text-primary fw-bold">Imagens do Produto</label>
    <div class="mb-2">
        <span class="badge bg-light text-dark mb-1">Principal</span>
        <input type="file" name="image_file" class="form-control" accept="image/*">
    </div>
    <div class="mb-2">
        <span class="badge bg-light text-dark mb-1">Opcional 2</span>
        <input type="file" name="image_file2" class="form-control" accept="image/*">
    </div>
    <div class="">
        <span class="badge bg-light text-dark mb-1">Opcional 3</span>
        <input type="file" name="image_file3" class="form-control" accept="image/*">
    </div>
</div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary w-100 rounded-3">Salvar Alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                        $lista_modals .= ob_get_clean();
                    endforeach; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $lista_modals ?>

<script>
function confirmarExclusao(id, nome) {
    Swal.fire({
        title: 'Excluir ' + nome + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir',
        confirmButtonColor: '#e64a85'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `index.php?url=admin/excluir-produto&id=${id}`;
        }
    });
}
</script>

<?php include(__DIR__ . '/../partials/footer.php'); ?>

<div class="modal fade" id="modalNovo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title font-heading fw-bold">Adicionar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?url=admin/salvar-produto" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small">Nome do Produto</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Categoria</label>
                        <select name="category" class="form-select" required>
                            <option value="">Selecione uma categoria</option>
                            <?php 
                            // LOOP QUE BUSCA AS CATEGORIAS PASSADAS PELO CONTROLADOR
                            foreach ($categorias as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['service_name']) ?>">
                                    <?= htmlspecialchars($cat['service_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Descrição</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Imagens (Principal e Opcionais)</label>
                        <input type="file" name="image_file" class="form-control mb-2" accept="image/*">
                        <input type="file" name="image_file2" class="form-control mb-2" accept="image/*">
                        <input type="file" name="image_file3" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="action" value="save" class="btn btn-primary w-100 rounded-3">Salvar Produto</button>
                </div>
            </form>
        </div>
    </div>
</div>