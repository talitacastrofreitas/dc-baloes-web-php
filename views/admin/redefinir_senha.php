<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow rounded-4 p-4">
                <h4 class="fw-bold mb-3">Redefinir Senha</h4>
                <form action="index.php?url=admin/salvar-nova-senha" method="POST">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                    <div class="mb-3">
                        <label class="small">Nova Senha</label>
                        <input type="password" name="nova_senha" class="form-control" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Atualizar Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>