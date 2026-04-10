<?php
$serverName = "localhost"; 
$connectionInfo = array("Database"=>"DCBaloes", "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}
?>