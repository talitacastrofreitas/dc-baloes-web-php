<?php
include('config.php');
include('verificar_admin.php');

if (isset($_GET['del'])) {
    $sql = "DELETE FROM PriceCalculation WHERE id = ?";
    sqlsrv_query($conn, $sql, array($_GET['del']));
    header("Location: calculadora.php?excluido=1");
    exit();
}

// A lógica de edição pode ser feita carregando os dados de volta no form da calculadora.php 
// passando o ID via GET: calculadora.php?edit=ID