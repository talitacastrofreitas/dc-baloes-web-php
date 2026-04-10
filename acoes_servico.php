<?php
include('config.php');
include('verificar_admin.php');

// Ação de Excluir
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $sql = "DELETE FROM Services WHERE id = ?";
    $stmt = sqlsrv_query($conn, $sql, array($id));
    
    if ($stmt) {
        header("Location: servicos.php?msg=excluido");
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
    exit();
}

// Ação de Editar (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_service'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $min = $_POST['min_value'];

    $sql = "UPDATE Services SET service_name = ?, service_description = ?, min_value = ? WHERE id = ?";
    $params = array($name, $desc, $min, $id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        header("Location: servicos.php?msg=atualizado");
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
    exit();
}


?>