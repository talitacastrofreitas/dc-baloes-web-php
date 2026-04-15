<?php include(__DIR__ . '/../partials/header.php'); ?>

    <title>Login Administrativo</title>

<div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow border-0 rounded-4">
                    <h2 class="text-center fw-bold mb-4">Acesso Admin</h2>
                    
                

                    <form action="index.php?url=fazer-login" method="POST">
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>

                            <div class="text-end mt-2">
        <a href="index.php?url=esqueci-senha" class="text-pink small text-decoration-none">Esqueci minha senha</a>
    </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>
