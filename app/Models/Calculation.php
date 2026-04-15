<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\ServiceModel;
use PDO;

class CalculationController {
    
    public function index() {
        verificarLogin();
        $db = Database::getConnection();
        
        // 1. Busca configurações padrão para pré-preencher valor hora e margem
        $stmt = $db->query("SELECT * FROM settings WHERE id = 1");
        $defaults = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Busca categorias/serviços para o select
        $serviceModel = new ServiceModel();
        $servicos = $serviceModel->getAll();

        // 3. Busca histórico de orçamentos (últimos 10)
        $stmtOrc = $db->query("SELECT * FROM PriceCalculation ORDER BY created_date DESC LIMIT 10");
        $orcamentos = $stmtOrc->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../views/admin/calculadora.php';
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getConnection();
            
            // Dados do formulário
            $material = (float)$_POST['material_cost'];
            $horas = (float)$_POST['labor_hours'];
            $valorHora = (float)$_POST['hourly_rate'];
            $frete = (float)$_POST['delivery_fee'];
            $markup = (float)$_POST['markup'];

            // Cálculo do preço final
            $custoTotal = $material + ($horas * $valorHora) + $frete;
            $precoFinal = $custoTotal * (1 + ($markup / 100));

            $sql = "INSERT INTO PriceCalculation 
                    (client_name, client_phone, service_type, name, material_cost, labor_hours, hourly_rate, delivery_fee, markup_percentage, final_price, created_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                $_POST['client_name'],
                $_POST['client_phone'],
                $_POST['service_type'],
                $_POST['name'],
                $material,
                $horas,
                $valorHora,
                $frete,
                $markup,
                $precoFinal
            ]);

            header("Location: index.php?url=calculadora&sucesso=1");
            exit();
        }
    }

    public function excluir() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM PriceCalculation WHERE id = ?");
            $stmt->execute([$id]);
        }
        header("Location: index.php?url=calculadora&excluido=1");
        exit();
    }
}