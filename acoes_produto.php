<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'save') {
 $images = [null, null, null];
$file_keys = ['image_file', 'image_file2', 'image_file3'];

foreach ($file_keys as $index => $key) {
    if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
        $new_name = uniqid('img_', true) . '.' . pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
        $destination = 'uploads/' . $new_name;
        if (move_uploaded_file($_FILES[$key]['tmp_name'], $destination)) {
            $images[$index] = $destination;
        }
    }
}

$sql = "INSERT INTO BalloonProduct (name, category, description, image_url, image_url2, image_url3, is_active) 
        VALUES (?, ?, ?, ?, ?, ?, 1)";
$params = array($_POST['name'], $_POST['category'], $_POST['description'], $images[0], $images[1], $images[2]);
$stmt = sqlsrv_query($conn, $sql, $params);

// Agora a verificação funcionará corretamente
if($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

header("Location: gerenciar.php");
exit();
}


if ($_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $is_active = $_POST['is_active'];
    $desc = $_POST['description'];

    // Lógica simples de update (expanda para incluir imagens se necessário)
    $sql = "UPDATE BalloonProduct SET name = ?, is_active = ?, description = ? WHERE id = ?";
    $params = array($name, $is_active, $desc, $id);
    sqlsrv_query($conn, $sql, $params);
    
    header("Location: gerenciar.php?sucesso=1");
}


if (isset($_GET['del'])) {
    $id = intval($_GET['del']); // Garante que o ID é um número inteiro por segurança
    
    // 1. Opcional: Buscar o caminho da imagem para apagar o ficheiro físico da pasta uploads
    $sql_img = "SELECT image_url FROM BalloonProduct WHERE id = ?";
    $stmt_img = sqlsrv_query($conn, $sql_img, array($id));
    if ($row = sqlsrv_fetch_array($stmt_img, SQLSRV_FETCH_ASSOC)) {
        if (!empty($row['image_url']) && file_exists($row['image_url'])) {
            unlink($row['image_url']); // Apaga o ficheiro físico
        }
    }

    // 2. Executar a exclusão no SQL Server
    $sql_del = "DELETE FROM BalloonProduct WHERE id = ?";
    $stmt_del = sqlsrv_query($conn, $sql_del, array($id));

    if ($stmt_del) {
        header("Location: gerenciar.php?excluido=1");
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
    exit();
}
?>