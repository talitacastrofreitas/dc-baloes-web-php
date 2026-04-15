<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                // Puxa as variáveis do seu arquivo .env que você configurou
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_DATABASE'] ?? '';
$user = $_ENV['DB_USERNAME'] ?? '';
$pass = $_ENV['DB_PASS'] ?? '';

               $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
                
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$connection = new PDO($dsn, $user, $pass, $options);
                
            } catch (PDOException $e) {
                // No InfinityFree, erros de conexão são comuns se os dados no .env estiverem errados
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}