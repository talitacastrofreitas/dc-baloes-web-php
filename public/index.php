<?php
session_start(); // OBRIGATÓRIO SER A PRIMEIRA LINHA

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function verificarLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?url=login&erro=necessario_login");
        exit();
    }
}


require_once __DIR__ . '/../vendor/autoload.php';

// Carrega variáveis de ambiente (.env)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$url = $_GET['url'] ?? 'home';

switch ($url) {
    case 'home':
        (new App\Controllers\HomeController())->index();
        break;

    case 'login':
        (new App\Controllers\AuthController())->showLogin();
        break;

    case 'fazer-login':
        (new App\Controllers\AuthController())->login();
        break;

    case 'logout':
        (new App\Controllers\AuthController())->logout();
        break;

    // Rotas Protegidas
    case 'calculadora':
        
        (new App\Controllers\CalculationController())->index();
        break;

    case 'admin/gerenciar':
        
        (new App\Controllers\AdminController())->gerenciar();
        break;

    case 'admin/servicos':
        
        (new App\Controllers\AdminController())->servicos();
        break;

    case 'admin/configuracoes':
        
        (new App\Controllers\AdminController())->configuracoes();
        break;

    case 'admin/salvar-produto':
        
        (new App\Controllers\AdminController())->salvarProduto();
        break;

    case 'admin/atualizar-produto':
        
        (new App\Controllers\AdminController())->atualizarProduto();
        break;

    case 'admin/excluir-produto':
        
        (new App\Controllers\AdminController())->excluirProduto();
        break;

    case 'admin/salvar-servico':
        
        (new App\Controllers\AdminController())->salvarServico();
        break;

    case 'admin/excluir-servico':
        
        (new App\Controllers\AdminController())->excluirServico();
        break;

    case 'admin/atualizar-servico':
        
        (new App\Controllers\AdminController())->atualizarServico();
        break;

    case 'admin/salvar-configuracoes':
        
        (new App\Controllers\AdminController())->salvarConfiguracoes();
        break;

    case 'admin/salvar-calculo':
        
        (new App\Controllers\CalculationController())->salvar();
        break;

    case 'admin/excluir-calculo':
        
        (new App\Controllers\CalculationController())->excluir();
        break;

    case 'admin/usuarios':
        
        (new App\Controllers\UserController())->index();
        break;

    case 'admin/salvar-usuario':
        
        (new App\Controllers\UserController())->salvarUsuario();
        break;

        case 'admin/excluir-usuario':
    (new App\Controllers\UserController())->excluirUsuario();
    break;

    case 'admin/redefinir-senha':
    case 'admin/salvar-nova-senha':
        
        (new App\Controllers\UserController())->redefinirSenha();
        break;

    // Rotas Públicas
    case 'produto/detalhes':
        (new App\Controllers\ProductController())->detalhes();
        break;

    case 'esqueci-senha':
        (new App\Controllers\UserController())->esqueciSenha();
        break;

    case 'processar-esqueci-senha':
        (new App\Controllers\UserController())->processarEsqueciSenha();
        break;

    case 'redefinir-senha-publico':
        (new App\Controllers\UserController())->redefinirSenhaPublico();
        break;

    case 'salvar-senha-recuperada':
        (new App\Controllers\UserController())->salvarSenhaRecuperada();
        break;

    case 'validar-codigo':
        require_once __DIR__ . '/../views/public/validar_codigo.php';
        break;

    case 'conferir-codigo':
        (new App\Controllers\UserController())->conferirCodigo();
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada.";
        break;
}