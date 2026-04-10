<?php 
include('verificar_admin.php'); 
include('header.php'); 
include('config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE Settings SET default_hourly_rate = ?, default_markup_percentage = ? WHERE id = 1";
    sqlsrv_query($conn, $sql, array($_POST['hourly'], $_POST['markup']));
    echo "<script>Swal.fire('Sucesso', 'Configurações atualizadas', 'success');</script>";
}

$res = sqlsrv_query($conn, "SELECT * FROM Settings WHERE id = 1");
$settings = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
?>

<div class="container py-5">
    <h2 class="font-heading fw-bold mb-4">Configurações do Sistema</h2>
    <div class="card p-4 border-0 shadow-sm rounded-4">
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="small">Valor da Hora Padrão (R$)</label>
                    <input type="number" step="0.01" name="hourly" class="form-control" value="<?php echo $settings['default_hourly_rate']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="small">Margem de Lucro Padrão (%)</label>
                    <input type="number" name="markup" class="form-control" value="<?php echo $settings['default_markup_percentage']; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Salvar Padrões</button>
        </form>
    </div>
</div>