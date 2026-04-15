<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <div class="text-center py-5 mb-5 rounded-5 shadow-sm" style="background: linear-gradient(135deg, #fff5f8 0%, #ffffff 100%); border: 1px solid #fce4ec;">
        <h1 class="font-heading display-4 fw-bold">Transforme Momentos em <span style="color: #e64a85;">Magia</span></h1>
        <p class="text-muted lead">Os balões mais encantadores para a sua celebração.</p>
    </div>

<div class="d-flex flex-nowrap gap-2 mb-4 overflow-auto pb-3 custom-scroll-categories" style="-webkit-overflow-scrolling: touch;">
    
    <a href="index.php" class="btn btn-outline-secondary text-nowrap rounded-pill px-4 <?= empty($category) ? 'active' : '' ?>">
        Todos
    </a>

    <?php foreach ($categorias as $cat): ?>
        <?php 
            $nomeCategoria = $cat['service_name'] ?? ''; 
            $isActive = ($category === $nomeCategoria);
        ?>
        <a href="index.php?url=home&cat=<?= urlencode($nomeCategoria) ?>" 
           class="btn btn-outline-pink text-nowrap rounded-pill px-4 <?= $isActive ? 'active' : '' ?>" 
           style="border-color: #f8bbd0; color: #ad1457;">
           <?= htmlspecialchars($nomeCategoria) ?>
        </a>
    <?php endforeach; ?>
</div>
    
    <div class="row g-4">
        <?php foreach ($produtos as $row): 
            $imgs = array_filter([$row['image_url'], $row['image_url2'] ?? null, $row['image_url3'] ?? null]);
            $carousel_id = "carousel_prod_" . $row['id'];
        ?>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card">
                <div id="<?= $carousel_id; ?>" class="carousel slide" data-bs-interval="false">
                    <div class="carousel-inner">
                        <?php if (empty($imgs)): ?>
                            <div class="carousel-item active">
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span style="font-size: 3rem;">🎈</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($imgs as $index => $img_path): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?= $img_path; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (count($imgs) > 1): ?>
                    <div class="d-flex justify-content-center gap-3 py-2 bg-white border-bottom">
                        <button class="btn btn-sm btn-outline-pink rounded-pill px-3 py-0" type="button" data-bs-target="#<?= $carousel_id; ?>" data-bs-slide="prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-pink rounded-pill px-3 py-0" type="button" data-bs-target="#<?= $carousel_id; ?>" data-bs-slide="next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <span class="badge bg-light text-pink mb-2" style="color: #e64a85;"><?= htmlspecialchars($row['category']); ?></span>
                    
                    <?php if(($row['min_value'] ?? 0) > 0): ?>
                        <div class="text-muted mb-2" style="font-size: 0.8rem;">
                            A partir de R$ <?= number_format($row['min_value'], 2, ',', '.'); ?>
                        </div>
                    <?php endif; ?>

                    <h5 class="card-title fw-bold"><?= htmlspecialchars($row['name']); ?></h5>
                    
                    <div class="d-grid mt-3">
                        <a href="index.php?url=produto/detalhes&id=<?= $row['id']; ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                            Ver detalhes
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>