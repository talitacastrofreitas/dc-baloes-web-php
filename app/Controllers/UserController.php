<?php
namespace App\Controllers;
use App\Models\User;

class UserController {
    public function index() {
        $userModel = new User();
        $usuarios = $userModel->getAll();
        require_once __DIR__ . '/../../views/admin/usuarios.php';
    }

    public function redefinirSenha() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $userModel->updatePassword($_POST['id'], $_POST['nova_senha']);
            header("Location: index.php?url=admin/usuarios&sucesso=1");
            exit();
        }
        require_once __DIR__ . '/../../views/admin/redefinir_senha.php';
    }

    public function esqueciSenha() {
    require_once __DIR__ . '/../../views/public/esqueci_senha.php';
}

public function processarEsqueciSenha() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = \App\Core\Database::getConnection();
        $email = trim($_POST['email']);

        $sql = "SELECT id, name FROM users WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            $codigo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Sintaxe MySQL: DATE_ADD e NOW()
            $sqlToken = "UPDATE users SET reset_token = ?, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?";
            $db->prepare($sqlToken)->execute([$codigo, $user['id']]);

            // Envio de e-mail (mantenha sua lógica de PHPMailer aqui)
            $template = \App\Core\Email::getResetTemplate($user['name'], $codigo);
            \App\Core\Email::send($email, "Código de Recuperação", $template);

            header("Location: index.php?url=validar-codigo&email=" . urlencode($email));
        } else {
            header("Location: index.php?url=esqueci-senha&erro=1");
        }
        exit();
    }
}

public function conferirCodigo() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $codigoDigitado = $_POST['codigo'];
        $db = \App\Core\Database::getConnection();

        // MySQL: token_expiry > NOW()
        $sql = "SELECT id FROM users 
                WHERE email = ? 
                AND reset_token = ? 
                AND token_expiry > NOW()";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$email, $codigoDigitado]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            header("Location: index.php?url=redefinir-senha-publico&token=" . $codigoDigitado . "&email=" . urlencode($email));
        } else {
            header("Location: index.php?url=validar-codigo&email=" . urlencode($email) . "&erro_codigo=1");
        }
        exit();
    }
}

public function salvarSenhaRecuperada() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = \App\Core\Database::getConnection();
        $email = $_POST['email'];
        $token = $_POST['token'];
        $novaSenha = $_POST['nova_senha'];


        // O segredo é esta linha: ela transforma o texto em hash
        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password_hash = ?, reset_token = NULL, token_expiry = NULL 
                WHERE reset_token = ? AND email = ?";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$hash, $token, $email]);

        header("Location: index.php?url=login&senha_resetada=1");
        exit();
    }
}

public function redefinirSenhaPublico() {
    $token = $_GET['token'] ?? null;
    $email = $_GET['email'] ?? null;

    if (!$token || !$email) {
        header("Location: index.php?url=login");
        exit();
    }

    // Opcional: Verificar no banco se o token ainda é válido antes de exibir a tela
    require_once __DIR__ . '/../../views/public/redefinir_senha_publico.php';
}

public function salvarUsuario() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id_usuario'] ?? '';
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $nivel = $_POST['nivel'];
        $password = $_POST['password'];
        $db = \App\Core\Database::getConnection();

        if (empty($id)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password_hash, nivel) VALUES (?, ?, ?, ?)";
            $db->prepare($sql)->execute([$nome, $email, $hash, $nivel]);
        } else {
            if (!empty($password)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET name = ?, email = ?, password_hash = ?, nivel = ? WHERE id = ?";
                $db->prepare($sql)->execute([$nome, $email, $hash, $nivel, $id]);
            } else {
                $sql = "UPDATE users SET name = ?, email = ?, nivel = ? WHERE id = ?";
                $db->prepare($sql)->execute([$nome, $email, $nivel, $id]);
            }
        }
        header("Location: index.php?url=admin/usuarios&sucesso=1");
        exit();
    }
}

public function excluirUsuario() {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $db = \App\Core\Database::getConnection();
        // Usando minúsculo para compatibilidade com InfinityFree
        $sql = "DELETE FROM users WHERE id = ?"; 
        $db->prepare($sql)->execute([$id]);
    }
    
    // Redireciona de volta para a lista disparando o Toastify
    header("Location: index.php?url=admin/usuarios&sucesso_exclusao=1");
    exit();
}
}