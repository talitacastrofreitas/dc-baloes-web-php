<?php
namespace App\Controllers;
use App\Models\Product;
use App\Models\ServiceModel;

class AdminController {
    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?url=login");
            exit();
        }
    }

  public function gerenciar() {
    verificarLogin();
    $productModel = new \App\Models\Product();
    $serviceModel = new \App\Models\ServiceModel();
    
    // Busca produtos para a tabela
    $produtos = $productModel->getAllAdmin();
    
    // BUSCA AS CATEGORIAS NO BANCO PARA O MODAL
    $categorias = $serviceModel->getAll(); 
    
    require_once __DIR__ . '/../../views/admin/gerenciar.php';
}

    public function excluirProduto() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            (new Product())->delete($id);
        }
        header("Location: index.php?url=admin/gerenciar&excluido=1");
    }

public function servicos() {
    // Instancia o modelo de serviços para buscar os dados do banco
    $serviceModel = new \App\Models\ServiceModel();
    $servicos = $serviceModel->getAll(); // Busca a lista de serviços cadastrados

    // Carrega a View usando o caminho absoluto correto
    require_once __DIR__ . '/../../views/admin/servicos.php';
}
  public function salvarProduto() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productModel = new \App\Models\Product();
        // Passa o POST (dados) e o FILES (imagens) para o model
        $productModel->save($_POST, $_FILES); 
        
        header("Location: index.php?url=admin/gerenciar&sucesso=1");
        exit();
    }
}

public function atualizarProduto() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productModel = new \App\Models\Product();
        // Chama o método de update no Model passando os dados e arquivos
        $productModel->update($_POST, $_FILES); 
        
        header("Location: index.php?url=admin/gerenciar&atualizado=1");
        exit();
    }
}

public function salvarServico() {
    // Verifica se a sessão existe antes de processar
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?url=login");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Use a barra invertida \ para garantir que ele encontre o namespace App\Models
        $serviceModel = new \App\Models\ServiceModel();
        
        $resultado = $serviceModel->save($_POST);
        
     if ($resultado) {
        header("Location: index.php?url=admin/servicos&sucesso=1");
        exit();
    } else {
        // No PDO, os erros são exceções ou retornam falso. 
        // Se Database.php estiver correto, apenas redirecione com erro.
        header("Location: index.php?url=admin/servicos&erro=1");
        exit();
    }
    }
}

public function excluirServico() {
    $id = $_GET['id'] ?? null;
    
    if ($id) {
        $serviceModel = new \App\Models\ServiceModel();
        // Agora o método delete() abaixo existirá e não dará mais erro
        $serviceModel->delete($id);
    }
    
    header("Location: index.php?url=admin/servicos&excluido=1");
    exit();
}

public function atualizarServico() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $serviceModel = new \App\Models\ServiceModel();
        $serviceModel->update($_POST); // Você precisará criar o método update no ServiceModel
        header("Location: index.php?url=admin/servicos&atualizado=1");
        exit();
    }
}

public function configuracoes() {
    verificarLogin();
    $serviceModel = new \App\Models\ServiceModel();
    $settings = $serviceModel->getSettings(); // Busca os dados atuais
    
    require_once __DIR__ . '/../../views/admin/configuracoes.php';
}

public function salvarConfiguracoes() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $serviceModel = new \App\Models\ServiceModel();
        
        // Usa o operador ?? para evitar o "Undefined array key" 
        // e garante que valores vazios virem '0'
        $hourly = !empty($_POST['hourly_rate']) ? $_POST['hourly_rate'] : 0;
        $markup = !empty($_POST['markup']) ? $_POST['markup'] : 0;
        $whatsapp = $_POST['whatsapp'] ?? '';

        $sucesso = $serviceModel->saveSettings($hourly, $markup, $whatsapp);

        header("Location: index.php?url=admin/configuracoes&" . ($sucesso ? "sucesso=1" : "erro=1"));
        exit();
    }
}
    
}