<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $email = trim($_POST['email']);
$password = trim($_POST['senha']); // O trim é essencial aqui

$sql = "SELECT id, name, CAST(password_hash AS NVARCHAR(MAX)) as password_hash FROM Users WHERE email = ?";
$stmt = sqlsrv_query($conn, $sql, array($email));
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if (!$user) {
    die("Erro: Usuário não encontrado no banco de dados. Verifique o e-mail.");
}
if (!password_verify($password, $user['password_hash'])) {
    echo "DEBUG - Senha digitada: " . $password . "<br>";
    echo "DEBUG - Hash no banco: " . $user['password_hash'] . "<br>";
    die("Erro: A senha não confere com o hash do banco.");
}

    // password_verify é o padrão profissional para checar senhas
   // No arquivo login.php, substitua o bloco de verificação por este:
if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_nome'] = $user['name'];
    header("Location: gerenciar.php");
    exit();
} else {
    $erro = "E-mail ou senha incorretos.";
}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login Administrativo</title>
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow border-0 rounded-4">
                    <h2 class="text-center font-heading fw-bold mb-4">Acesso Admin</h2>
                    <?php if(isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
                    <form method="POST">
                     <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required placeholder="admin@teste.com">
    </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>