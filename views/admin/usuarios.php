<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <h2 class="fw-bold mb-0">Gestão de Usuários</h2>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="novoUsuario()">
            <i class="fa-solid fa-user-plus me-2"></i> Novo Usuário
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive"> <table class="table align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3">Nome</th>
                        <th class="d-none d-md-table-cell">E-mail</th> <th>Nível</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark"><?= htmlspecialchars($u['name'] ?? 'Usuário') ?></div>
                            <div class="small text-muted d-md-none"><?= htmlspecialchars($u['email']) ?></div> </td>
                        <td class="d-none d-md-table-cell text-muted"><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="badge rounded-pill bg-soft-primary text-primary border">
                                <?= ucfirst($u['nivel'] ?? 'admin') ?>
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="index.php?url=admin/redefinir-senha&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
                                   <i class="fa-solid fa-key"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="editarUsuario('<?= $u['id'] ?>', '<?= $u['name'] ?>', '<?= $u['email'] ?>', '<?= $u['nivel'] ?>')">
                                   <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="confirmarExclusaoGeral('index.php?url=admin/excluir-usuario&id=<?= $u['id'] ?>')">
                                   <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitulo">Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUsuario" action="index.php?url=admin/salvar-usuario" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_usuario">
                    <div class="mb-3">
                        <label class="small">Nome Completo</label>
                        <input type="text" name="nome" class="form-control rounded-pill" required>
                    </div>
                    <div class="mb-3">
                        <label class="small">E-mail</label>
                        <input type="email" name="email" class="form-control rounded-pill" required>
                    </div>
                    <div class="mb-3">
                        <label class="small">Senha (Deixe em branco para manter a atual na edição)</label>
                        <input type="password" name="password" class="form-control rounded-pill">
                    </div>
                    <div class="mb-3">
                        <label class="small">Nível</label>
                        <select name="nivel" class="form-select rounded-pill">
                            <option value="admin">Administrador</option>
                            <option value="colaborador">Colaborador</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>


<script>
function novoUsuario() {
    const modalElement = document.getElementById('modalUsuario');
    const modal = bootstrap.Modal.getOrCreateInstance(modalElement); // Melhor para evitar conflitos
    document.getElementById('formUsuario').reset();
    document.getElementsByName('id_usuario')[0].value = ""; // Limpa ID
    document.getElementById('modalTitulo').innerText = "Novo Usuário";
    modal.show();
}

function editarUsuario(id, nome, email, nivel) {
    const modalElement = document.getElementById('modalUsuario');
    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
    document.getElementById('modalTitulo').innerText = "Editar Usuário";
    
    document.getElementsByName('id_usuario')[0].value = id;
    document.getElementsByName('nome')[0].value = nome;
    document.getElementsByName('email')[0].value = email;
    document.getElementsByName('nivel')[0].value = nivel;
    
    // Na edição, a senha não é obrigatória
    document.getElementsByName('password')[0].required = false;
    
    modal.show();
}
</script>