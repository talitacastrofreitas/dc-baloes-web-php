<?php
namespace App\Controllers;
use App\Models\Product;

class ProductController {
    public function index() {
        $productModel = new Product();
        $produtos = $productModel->getAll();
        
        // Carrega a visão
        require_once __DIR__ . '/../../views/public/index.php';
    }

public function detalhes() {
    $id = $_GET['id'] ?? null;
    $serviceModel = new \App\Models\ServiceModel();
    $productModel = new \App\Models\Product();

    $produto = $productModel->getById($id);
    $settings = $serviceModel->getSettings(); // ESSA LINHA É ESSENCIAL

    require_once __DIR__ . '/../../views/public/detalhes.php';
}
}