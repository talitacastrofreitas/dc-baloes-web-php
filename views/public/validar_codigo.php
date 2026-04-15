<?php include(__DIR__ . '/../partials/header.php'); ?>
<div class="container py-5 text-center">
    <div class="card border-0 shadow-lg rounded-4 p-4 d-inline-block" style="max-width: 400px;">
        <h4 class="fw-bold">Verifique seu e-mail</h4>
        <p class="text-muted small">Enviamos um código de 6 dígitos para o seu e-mail.</p>
        
        <form action="index.php?url=conferir-codigo" method="POST">
            <input type="hidden" name="email" value="<?= $_GET['email'] ?>">
            <input type="text" name="codigo" class="form-control form-control-lg text-center fw-bold mb-3" 
                   placeholder="000000" maxlength="6" required>
            <button type="submit" class="btn btn-primary w-100 rounded-pill">Validar Código</button>
        </form>
    </div>
</div>
<?php include(__DIR__ . '/../partials/footer.php'); ?>