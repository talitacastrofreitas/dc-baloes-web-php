<?php 
include('verificar_admin.php'); // Adicione isto no topo
include('header.php'); 
include('config.php'); 
?>
<div class="container py-5">
    <h2 class="font-heading fw-bold mb-4">Calculadora de Preços</h2>
    <div class="row">
        <div class="col-md-7">
            <div class="card p-4 shadow-sm border-0 rounded-4">
                <form action="processar_calculo.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Nome do Cálculo</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ex: Arco de Balões Luxo">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small">Custo de Materiais (R$)</label>
                            <input type="number" step="0.01" name="material_cost" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Margem de Lucro (%)</label>
                            <input type="number" name="markup" class="form-control" value="50" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Horas de Trabalho</label>
                            <input type="number" step="0.1" name="labor_hours" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Valor por Hora (R$)</label>
                            <input type="number" step="0.01" name="hourly_rate" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4 rounded-3">Salvar Cálculo</button>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <h5 class="mb-3">Últimos Cálculos</h5>
            <?php
            $query = sqlsrv_query($conn, "SELECT TOP 5 * FROM PriceCalculation ORDER BY created_date DESC");
            while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)): ?>
                <div class="card mb-2 p-3 border-0 shadow-sm rounded-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold small"><?php echo $row['name']; ?></div>
                            <div class="text-muted" style="font-size: 0.75rem;">Final: R$ <?php echo number_format($row['final_price'], 2, ',', '.'); ?></div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>