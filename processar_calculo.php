<?php
include('config.php');
include('verificar_admin.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $client = $_POST['client_name'];
    $phone = $_POST['client_phone'];
    $service = $_POST['service_type'];
    $name = $_POST['name'];
    $desc = $_POST['description']; // Captura a descrição
    $mat = (float)$_POST['material_cost'];
    $hours = (float)$_POST['labor_hours'];
    $rate = (float)$_POST['hourly_rate'];
    $markup = (float)$_POST['markup'];
    $delivery = (float)$_POST['delivery_fee'];

    $labor_total = $hours * $rate;
    $total_cost = $mat + $labor_total + $delivery;
    $profit = $total_cost * ($markup / 100);
    $final = $total_cost + $profit;

    if (!empty($id)) {
    $sql = "UPDATE PriceCalculation SET 
            client_name = ?, client_phone = ?, service_type = ?, name = ?, description = ?, 
            material_cost = ?, labor_hours = ?, hourly_rate = ?, markup_percentage = ?, 
            delivery_fee = ?, total_cost = ?, final_price = ?, profit = ? 
            WHERE id = ?";
    // O quinto parâmetro deve ser o $desc
    $params = array($client, $phone, $service, $name, $desc, $mat, $hours, $rate, $markup, $delivery, $total_cost, $final, $profit, $id);
} else {
    $sql = "INSERT INTO PriceCalculation (client_name, client_phone, service_type, name, description, material_cost, labor_hours, hourly_rate, markup_percentage, delivery_fee, total_cost, final_price, profit) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array($client, $phone, $service, $name, $desc, $mat, $hours, $rate, $markup, $delivery, $total_cost, $final, $profit);
}
    $stmt = sqlsrv_query($conn, $sql, $params);
    header("Location: calculadora.php?sucesso=1");
    exit();
}