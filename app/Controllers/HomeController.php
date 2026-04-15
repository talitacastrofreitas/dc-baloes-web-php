<?php
namespace App\Controllers;
use App\Models\Product;
use App\Models\ServiceModel; // Importe o modelo de serviços

class HomeController {
    public function index() {
        $category = $_GET['cat'] ?? null;
        
        $productModel = new Product();
        $produtos = $productModel->getActiveProducts($category); 
        
        // Buscando categorias (serviços) dinamicamente do banco
        $serviceModel = new ServiceModel();
        $categorias = $serviceModel->getAll(); // Método que busca todos os serviços

        require_once __DIR__ . '/../../views/public/home.php';
    }
}