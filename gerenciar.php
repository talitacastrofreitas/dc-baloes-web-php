<?php
include('verificar_admin.php');
include('header.php');
include('config.php');
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-heading fw-bold">Gestão de Catálogo</h2>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalNovo">
            + Novo Produto
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive p-3">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small text-uppercase">
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Preço Base (Mínimo)</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_list = "SELECT p.*, s.min_value 
                                 FROM BalloonProduct p 
                                 LEFT JOIN Services s ON p.category = s.service_name 
                                 ORDER BY p.created_at DESC";

                    $res = sqlsrv_query($conn, $sql_list);
                    $lista_modals = ""; 

                    while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)):
                        $preco_base = isset($row['min_value']) ? (float)$row['min_value'] : 0;
                        $prod_id = $row['id'];
                    ?>
                        <tr>
                            <td><div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div></td>
                            <td><span class="badge bg-light text-dark"><?php echo htmlspecialchars($row['category']); ?></span></td>
                            <td>
                                <div class="fw-bold text-primary">
                                    R$ <?php echo number_format($preco_base, 2, ',', '.'); ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($row['is_active']): ?>
                                    <span class="text-success small">● Ativo</span>
                                <?php else: ?>
                                    <span class="text-danger small">● Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-link text-primary p-0 me-2" data-bs-toggle="modal" data-bs-target="#modalEditar<?php echo $prod_id; ?>">
                                    Editar
                                </button>
                                <a href="javascript:void(0);" class="btn btn-link text-danger p-0 btn-excluir"
                                   data-id="<?php echo $prod_id; ?>" data-nome="<?php echo htmlspecialchars($row['name']); ?>">
                                    Excluir
                                </a>
                            </td>
                        </tr>

                        <?php
                        ob_start();
                        ?>
                        <div class="modal fade" id="modalEditar<?php echo $prod_id; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Editar Produto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="acoes_produto.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $prod_id; ?>">
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label small">Nome do Produto</label>
                                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Categoria</label>
                                                <select name="category" class="form-select">
                                                    <?php
                                                    $serv_res = sqlsrv_query($conn, "SELECT service_name FROM Services");
                                                    while ($s = sqlsrv_fetch_array($serv_res, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($s['service_name'] == $row['category']) ? 'selected' : '';
                                                        echo "<option value='{$s['service_name']}' $selected>{$s['service_name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Status</label>
                                                <select name="is_active" class="form-select">
                                                    <option value="1" <?php echo $row['is_active'] ? 'selected' : ''; ?>>Ativo (Visível no site)</option>
                                                    <option value="0" <?php echo !$row['is_active'] ? 'selected' : ''; ?>>Inativo (Oculto)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Preço Base (Edite apenas em 'Serviços')</label>
                                                <input type="text" class="form-control bg-light" value="R$ <?php echo number_format($preco_base, 2, ',', '.'); ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Descrição</label>
                                                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($row['description'] ?? ''); ?></textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small text-primary">Alterar Imagem Principal (Opcional)</label>
                                                <input type="file" name="image_file" class="form-control mb-1" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" name="action" value="update" class="btn btn-primary w-100 rounded-3">Salvar Alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                        $lista_modals .= ob_get_clean();
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNovo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title font-heading fw-bold">Adicionar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="acoes_produto.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small">Nome do Produto</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Categoria</label>
                        <select name="category" class="form-select">
                            <?php
                            $serv_res = sqlsrv_query($conn, "SELECT service_name FROM Services");
                            while ($s = sqlsrv_fetch_array($serv_res, SQLSRV_FETCH_ASSOC)) {
                                echo "<option value='{$s['service_name']}'>{$s['service_name']}</option>";
                            }
                            ?>
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

<?php echo $lista_modals; ?>

<script>
    document.querySelectorAll('.btn-excluir').forEach(botao => {
        botao.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');
            Swal.fire({
                title: 'Tem certeza?',
                text: `Você deseja excluir o produto "${nome}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e64a85',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = `acoes_produto.php?del=${id}`;
            });
        });
    });
</script>