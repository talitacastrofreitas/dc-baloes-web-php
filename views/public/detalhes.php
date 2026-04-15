<?php include(__DIR__ . '/../partials/header.php');

$whatsapp = !empty($settings['whatsapp_number']) ? $settings['whatsapp_number'] : '5571999999999'; 
    $mensagem = urlencode("Olá! Vi o produto " . $produto['name'] . " no site e gostaria de um orçamento.");

     ?>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide shadow rounded-4 overflow-hidden mb-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    $imgs = array_filter([$produto['image_url'], $produto['image_url2'] ?? null, $produto['image_url3'] ?? null]);
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
            <span class="badge bg-light text-pink mb-2" style="color: #e64a85; padding: 8px 15px;"><?php echo htmlspecialchars($produto['category']); ?></span>
            <h1 class="font-heading fw-bold mb-3"><?php echo htmlspecialchars($produto['name']); ?></h1>
            <h3 class="text-primary fw-bold mb-4">A partir de R$ <?php echo number_format($produto['min_value'] ?? 0, 2, ',', '.'); ?></h3>
            
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">Descrição do Produto</h5>
                <p class="text-muted mb-0" style="line-height: 1.8;">
                    <?php echo nl2br(htmlspecialchars($produto['description'] ?? '')); ?>
                </p>
            </div>

            <div class="d-grid gap-3">
             <a href="https://api.whatsapp.com/send?phone=<?= $whatsapp ?>&text=<?= $mensagem ?>" 
   target="_blank" 
   class="btn btn-success btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm">
    💬 Conversar no WhatsApp
</a>
                <a href="index.php?url=home" class="btn btn-outline-secondary btn-lg rounded-pill shadow-sm">
                    ⬅ Voltar para a Loja
                </a>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>