<?php
$senha_digitada = "admin123";
$hash_do_banco = '$2y$10$8S4F/2F0G5h8kL7mN9qO.e7v6j5H4G3F2E1D0C9B8A7';

if (password_verify($senha_digitada, $hash_do_banco)) {
    echo "O PHP está funcionando corretamente. O problema é a comunicação com o SQL Server.";
} else {
    echo "Erro de validação. Tente gerar um novo hash com: " . password_hash("admin123", PASSWORD_DEFAULT);
}
?>