<?php 
// Lógica de validação do token aqui ou no controller
if (!isset($_GET['token'])) die("Acesso negado.");
?>

<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                <h4 class="fw-bold mb-3 text-center">Nova Senha</h4>
                <form action="index.php?url=salvar-senha-recuperada" method="POST">
                    <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
                    <div class="mb-3">
                        <label class="small">Digite sua nova senha de Admin</label>
                        <input type="password" name="nova_senha" class="form-control form-control-lg rounded-pill" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-lg rounded-pill">Confirmar Nova Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>