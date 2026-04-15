<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <h2 class="font-heading fw-bold mb-4">Configurações do Sistema</h2>
    <div class="card p-4 border-0 shadow-sm rounded-4">
     <form action="index.php?url=admin/salvar-configuracoes" method="POST">
        <div class="row">
    <div class="col-6 mb-3">
        <label>Valor da Hora (R$)</label>
        <input type="number" step="0.01" name="hourly_rate" class="form-control" 
               value="<?= $settings['default_hourly_rate'] ?? '' ?>" required>
    </div>
    <div class="col-6 mb-3">
        <label>Margem de Lucro (%)</label>
        <input type="number" step="0.01" name="markup" class="form-control" 
               value="<?= $settings['default_markup_percentage'] ?? '' ?>" required>
    </div>
    </div>


    <div class="col-6 mb-3">
        <label>WhatsApp</label>
        <!-- <input type="text" name="whatsapp" class="form-control" 
               value="<?= $settings['whatsapp_number'] ?? '' ?>"> -->

               <input type="text" name="whatsapp" class="form-control mask-phone" 
       placeholder="(71) 98888-8888" maxlength="15"
       value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '') ?>">
    </div>

    
    <button type="submit" class="btn btn-primary">Salvar Configurações</button>
</form>
    </div>
</div>

<?php if (isset($_GET['sucesso'])): ?>
<script>
    Swal.fire('Sucesso', 'Configurações atualizadas', 'success');
</script>
<?php endif; ?>

<?php include(__DIR__ . '/../partials/footer.php'); ?>