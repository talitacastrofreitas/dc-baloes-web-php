<?php
namespace App\Controllers;
use App\Models\User;

class AuthController {
    public function showLogin() {
        require_once __DIR__ . '/../../views/public/login.php';
    }

public function login() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST['email']);
        $password = trim($_POST['senha']);

        $userModel = new \App\Models\User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            // GRAVAÇÃO DA SESSÃO
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['name'];
            
            // Força a gravação da sessão antes de redirecionar
            session_write_close(); 
            
            header("Location: index.php?url=admin/gerenciar");
            exit();
        } else {
            // Se falhar, volta com erro explícito
            header("Location: index.php?url=login&erro_login=1");
            exit();
        }
    }
}

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}