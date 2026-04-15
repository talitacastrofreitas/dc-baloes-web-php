<?php
namespace App\Controllers;
use App\Models\ServiceModel;
use App\Core\Database;
use PDO;

class CalculationController {
    public function index() {
        verificarLogin();
        $db = Database::getConnection();
        
        // Busca padrões de configurações
        $set_res = $db->query("SELECT * FROM settings WHERE id = 1");
        $defaults = $set_res->fetch(PDO::FETCH_ASSOC);

        // Busca serviços para o select
        $serviceModel = new ServiceModel();
        $servicos = $serviceModel->getAll();

        // Busca os últimos orçamentos - MySQL usa LIMIT em vez de TOP
        $query = $db->query("SELECT * FROM pricecalculation ORDER BY created_date DESC LIMIT 10");
        $orcamentos = $query->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../views/admin/calculadora.php';
    }

    public function salvar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = Database::getConnection();
        $id = $_POST['id'] ?? null;
        
        // Limpa a máscara para salvar apenas números no banco
        $telefone = preg_replace('/\D/', '', $_POST['client_phone']);
        
        // Lógica de cálculo
        $final_price = ($_POST['material_cost'] + ($_POST['labor_hours'] * $_POST['hourly_rate']) + $_POST['delivery_fee']) * (1 + ($_POST['markup'] / 100));

        if ($id) {
            $sql = "UPDATE pricecalculation SET client_name=?, client_phone=?, service_type=?, name=?, description=?, material_cost=?, markup_percentage=?, labor_hours=?, hourly_rate=?, delivery_fee=?, final_price=? WHERE id=?";
            // USAR $telefone AQUI v
            $params = [$_POST['client_name'], $telefone, $_POST['service_type'], $_POST['name'], $_POST['description'], $_POST['material_cost'], $_POST['markup'], $_POST['labor_hours'], $_POST['hourly_rate'], $_POST['delivery_fee'], $final_price, $id];
        } else {
            $sql = "INSERT INTO pricecalculation (client_name, client_phone, service_type, name, description, material_cost, markup_percentage, labor_hours, hourly_rate, delivery_fee, final_price, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            // USAR $telefone AQUI v
            $params = [$_POST['client_name'], $telefone, $_POST['service_type'], $_POST['name'], $_POST['description'], $_POST['material_cost'], $_POST['markup'], $_POST['labor_hours'], $_POST['hourly_rate'], $_POST['delivery_fee'], $final_price];
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        header("Location: index.php?url=calculadora&sucesso=1");
        exit();
    }
}

    public function excluir() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $db = Database::getConnection();
            $sql = "DELETE FROM pricecalculation WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
        }

        header("Location: index.php?url=calculadora&excluido=1");
        exit();
    }
}