<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/0de36d37a3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fdfafb; }
      
        .font-heading { font-family: 'Playfair Display', serif; }
        .navbar { background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
        .btn-primary { background-color: #e64a85; border: none; }
        .btn-primary:hover { background-color: #d13d75; }
    </style>
</head>
<body>

<main>


<?php 
if (session_status() === PHP_SESSION_NONE) session_start(); 
?>


<nav class="navbar navbar-expand-lg sticky-top border-bottom mb-4">
    <div class="container">
        <a class="navbar-brand font-heading fw-bold" href="index.php?url=home">
            <!-- 🎈 Balão<span style="color: #e64a85;">Fest</span> -->
             <img src="../views/partials/logo.jpeg" alt="" style="height: 80px; width: auto; border-radius: 5px;">
    </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto gap-2 py-3 py-lg-0">
                <a class="nav-link" href="index.php?url=home">Loja</a>
                
                <?php if(isset($_SESSION['usuario_id'])): ?> 
                    <a class="nav-link" href="index.php?url=calculadora">Calculadora</a>
                    <a class="nav-link" href="index.php?url=admin/gerenciar">Produtos</a>
                    <a class="nav-link <?= (strpos($url, 'admin/usuarios') !== false) ? 'text-primary fw-bold' : '' ?>" href="index.php?url=admin/usuarios">Usuários</a>
                    <a class="nav-link" href="index.php?url=admin/servicos">Serviços</a>
                    <a class="nav-link" href="index.php?url=admin/configuracoes">Configurações</a>
                    <hr class="d-lg-none"> <a class="nav-link text-danger" href="index.php?url=logout">Sair</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
function showToast(text, type = "success") {
    Toastify({
        text: text,
        duration: 3000,
        gravity: "top",
        position: "right",
        style: {
            background: type === "success" ? "#e64a85" : "#dc3545",
            borderRadius: "10px"
        }
    }).showToast();
}
</script>