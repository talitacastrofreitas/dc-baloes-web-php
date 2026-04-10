<?php include('header.php');
include('config.php'); ?>

<div class="container py-5">
    <div class="text-center py-5 mb-5 rounded-5 shadow-sm" style="background: linear-gradient(135deg, #fff5f8 0%, #ffffff 100%); border: 1px solid #fce4ec;">
        <h1 class="font-heading display-4 fw-bold">Transforme Momentos em <span style="color: #e64a85;">Magia</span></h1>
        <p class="text-muted lead">Os balões mais encantadores para a sua celebração.</p>
    </div>

    <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
        <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">Todos</a>
        <?php
        $categorias = ['Decoração de Festa', 'Arranjos', 'Balões Personalizados', 'Kits'];
        foreach ($categorias as $cat): ?>
            <a href="index.php?cat=<?php echo urlencode($cat); ?>" class="btn btn-outline-pink rounded-pill px-4" style="border-color: #f8bbd0; color: #ad1457;">
                <?php echo $cat; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM BalloonProduct WHERE is_active = 1";
        if (isset($_GET['cat'])) {
            $sql .= " AND category = ?";
            $params = array($_GET['cat']);
            $res = sqlsrv_query($conn, $sql, $params);
        } else {
            $res = sqlsrv_query($conn, $sql);
        }

       while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)): 
        // Filtra as imagens disponíveis para criar o carrossel
        $imgs = array_filter([$row['image_url'], $row['image_url2'] ?? null, $row['image_url3'] ?? null]);
        $carousel_id = "carousel_prod_" . $row['id'];
    ?>
        <div class="col-md-3">
          
                
<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card">
    <div id="<?php echo $carousel_id; ?>" class="carousel slide" data-bs-interval="false">
        <div class="carousel-inner">
            <?php if (empty($imgs)): ?>
                <div class="carousel-item active">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span style="font-size: 3rem;">🎈</span>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($imgs as $index => $img_path): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $img_path; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if (count($imgs) > 1): ?>
        <div class="d-flex justify-content-center gap-3 py-2 bg-white border-bottom">
            <button class="btn btn-sm btn-outline-pink rounded-pill px-3 py-0" type="button" data-bs-target="#<?php echo $carousel_id; ?>" data-bs-slide="prev" style="font-size: 0.8rem; border-color: #fce4ec; color: #ad1457;">
              <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="btn btn-sm btn-outline-pink rounded-pill px-3 py-0" type="button" data-bs-target="#<?php echo $carousel_id; ?>" data-bs-slide="next" style="font-size: 0.8rem; border-color: #fce4ec; color: #ad1457;">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    <?php endif; ?>

             <div class="card-body">
                    <?php
                    $sql_min = "SELECT min_value FROM Services WHERE service_name = ?";
                    $stmt_min = sqlsrv_query($conn, $sql_min, array($row['category']));
                    $servico = sqlsrv_fetch_array($stmt_min, SQLSRV_FETCH_ASSOC);
                    $valor_minimo = isset($servico['min_value']) ? (float)$servico['min_value'] : 0;
                    ?>

                    <span class="badge bg-light text-pink mb-2" style="color: #e64a85;"><?php echo htmlspecialchars($row['category']); ?></span>
                    
                    <?php if($valor_minimo > 0): ?>
                        <div class="text-muted mb-2" style="font-size: 0.8rem;">
                            A partir de R$ <?php echo number_format($valor_minimo, 2, ',', '.'); ?>
                        </div>
                    <?php endif; ?>

                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['name']); ?></h5>
                    
                    <div class="d-grid mt-3">
                        <a href="detalhes.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                            Ver detalhes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

    </div>
</div>


<footer class="mt-5 border-top bg-white">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start mb-4 mb-md-0">
                <h6 class="fw-bold mb-1">Créditos de Desenvolvimento</h6>
                <div class="small text-muted">
                    <span class="fw-semibold text-dark">Desenvolvedora:</span> Talita Castro Freitas<br>
                    Analista de Desenvolvimento de Software<br>
                    <span class="text-secondary">Graduação em Análise e Desenvolvimento de Sistemas | Pós-graduação em Engenharia de Software</span>
                </div>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <a href="login.php" class="btn btn-outline-pink btn-sm rounded-pill px-4 shadow-sm" style="border-color: #fce4ec; color: #ad1457; font-size: 0.85rem;">
                    🔒 Acesso Administrativo
                </a>
            </div>
        </div>

        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted">&copy; <?php echo date('Y'); ?> 🎈 BalãoFest - Todos os direitos reservados.</small>
        </div>
    </div>
</footer>