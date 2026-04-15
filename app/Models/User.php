<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class User {
    private $db;

  public function __construct() {
        $this->db = Database::getConnection();
    }

public function findByEmail($email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function getAll() {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password_hash = :pass WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['pass' => $hash, 'id' => $id]);
    }
}