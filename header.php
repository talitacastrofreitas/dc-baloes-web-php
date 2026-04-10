<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/0de36d37a3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fdfafb; }
      
        .font-heading { font-family: 'Playfair Display', serif; }
        .navbar { background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
        .btn-primary { background-color: #e64a85; border: none; }
        .btn-primary:hover { background-color: #d13d75; }
    </style>
</head>
<body>
<!-- <nav class="navbar navbar-expand-lg sticky-top border-bottom">
    
    <div class="container">
        <a class="navbar-brand font-heading fw-bold" href="index.php">🎈 Balão<span style="color: #e64a85;">Fest</span></a>
        <div class="navbar-nav">
            <a class="nav-link" href="index.php">Loja</a>
            <a class="nav-link" href="calculadora.php">Calculadora</a>
            <a class="nav-link" href="gerenciar.php">Produtos</a>
        </div>
    </div>
</nav> -->



<?php 
if (session_status() === PHP_SESSION_NONE) session_start(); 
?>
<nav class="navbar navbar-expand-lg sticky-top border-bottom mb-4">
    <div class="container">
        <a class="navbar-brand font-heading fw-bold" href="index.php">🎈 Balão<span style="color: #e64a85;">Fest</span></a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Loja</a>
            <?php if(isset($_SESSION['admin_id'])): ?> 
                <a class="nav-link" href="calculadora.php">Calculadora</a>
                <a class="nav-link" href="gerenciar.php">Produtos</a>
                <a class="nav-link" href="servicos.php">Serviços</a>
                <a class="nav-link text-danger" href="logout.php">Sair</a>
            <?php endif; ?>
        </div>
    </div>
</nav>