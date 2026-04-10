<?php 
include('header.php'); 
include('config.php'); 

$id = $_GET['id'] ?? header("Location: index.php");
$res = sqlsrv_query($conn, "SELECT p.*, s.min_value FROM BalloonProduct p 
                            LEFT JOIN Services s ON p.category = s.service_name 
                            WHERE p.id = ?", array($id));
$row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row g-5">
       <div class="col-md-6">
    <div id="productCarousel" class="carousel slide shadow rounded-4 overflow-hidden mb-3" data-bs-ride="carousel">
        
        <div class="carousel-inner">
            <?php 
            $imgs = array_filter([$row['image_url'], $row['image_url2'], $row['image_url3']]);
            if (empty($imgs)) $imgs[] = 'placeholder.png';
            foreach ($imgs as $i => $img): 
            ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>" data-bs-interval="3000">
                    <img src="<?php echo $img; ?>" class="d-block w-100" style="height: 500px; object-fit: cover;">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <button class="btn btn-outline-pink rounded-circle" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" style="width: 45px; height: 45px; color: #e64a85; border-color: #fce4ec;">
            <span>&lt;</span>
        </button>

        <div class="carousel-indicators-custom d-flex gap-2">
            <?php foreach ($imgs as $i => $img): ?>
                <div class="rounded-circle <?php echo $i === 0 ? 'bg-pink' : 'bg-light'; ?>" 
                     style="width: 10px; height: 10px; cursor: pointer; <?php echo $i === 0 ? 'background-color: #e64a85;' : 'background-color: #dee2e6;'; ?>"
                     onclick="new bootstrap.Carousel(document.getElementById('productCarousel')).to(<?php echo $i; ?>)">
                </div>
            <?php endforeach; ?>
        </div>

        <button class="btn btn-outline-pink rounded-circle" type="button" data-bs-target="#productCarousel" data-bs-slide="next" style="width: 45px; height: 45px; color: #e64a85; border-color: #fce4ec;">
            <span>&gt;</span>
        </button>
    </div>

   
</div>

        <div class="col-md-6">
            <span class="badge bg-light text-pink mb-2" style="color: #e64a85; padding: 8px 15px;"><?php echo htmlspecialchars($row['category']); ?></span>
            <h1 class="font-heading fw-bold mb-3"><?php echo htmlspecialchars($row['name']); ?></h1>
            <h3 class="text-primary fw-bold mb-4">A partir de R$ <?php echo number_format($row['min_value'], 2, ',', '.'); ?></h3>
            
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">Descrição do Produto</h5>
                <p class="text-muted mb-0" style="line-height: 1.8;">
                    <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                </p>
            </div>

             <div class="d-grid gap-3">
        <a href="https://wa.me/SEUNUMERO?text=Olá, tenho interesse no produto: <?php echo urlencode($row['name']); ?>" 
           class="btn btn-success btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm">
           💬 Conversar no WhatsApp
        </a>
        <a href="index.php" class="btn btn-outline-secondary btn-lg rounded-pill shadow-sm">
            ⬅ Voltar para a Loja
        </a>
    </div>
        </div>
    </div>
</div>