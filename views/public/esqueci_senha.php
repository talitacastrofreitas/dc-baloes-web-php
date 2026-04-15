<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Recuperar Acesso</h3>
                    <p class="text-muted small">Digite seu e-mail para validar o reset</p>
                </div>
                
                <form action="index.php?url=processar-esqueci-senha" method="POST">
                    <div class="mb-3">
                        <label class="form-label">E-mail Cadastrado</label>
                        <input type="email" name="email" class="form-control form-control-lg rounded-pill" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill">Enviar Solicitação</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="index.php?url=login" class="text-decoration-none small text-secondary">Voltar ao Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>