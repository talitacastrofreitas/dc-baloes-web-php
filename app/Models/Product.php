<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

public function getActiveProducts($category = null) {
        $sql = "SELECT p.*, s.min_value 
                FROM balloonproduct p 
                LEFT JOIN services s ON p.category = s.service_name 
                WHERE p.is_active = 1";
        
        if ($category) {
            $sql .= " AND p.category = :category";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['category' => $category]);
        } else {
            $stmt = $this->db->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  public function getAllAdmin() {
        $sql = "SELECT p.*, s.min_value 
                FROM balloonproduct p 
                LEFT JOIN services s ON p.category = s.service_name 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function updateStatus($id, $name, $isActive, $desc) {
        $sql = "UPDATE balloonproduct SET name = ?, is_active = ?, description = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $isActive, $desc, $id]);
    }

public function save($data, $files) {
        $images = ['default.png', 'default.png', 'default.png'];
        $uploadDir = __DIR__ . '/../../public/uploads/';

        // Mapeamento dos campos do formulário para as posições no banco
        $fileKeys = ['image_file', 'image_file2', 'image_file3'];

        foreach ($fileKeys as $index => $key) {
            if (isset($files[$key]) && $files[$key]['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($files[$key]['name'], PATHINFO_EXTENSION);
                $newName = "img_" . uniqid() . "." . $ext;
                
                if (move_uploaded_file($files[$key]['tmp_name'], $uploadDir . $newName)) {
                    $images[$index] = "uploads/" . $newName;
                }
            }
        }

        $sql = "INSERT INTO balloonproduct (name, category, description, image_url, image_url2, image_url3, is_active, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, 1, NOW())";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'], $data['category'], $data['description'], 
            $images[0], $images[1], $images[2]
        ]);
    }

    public function delete($id) {
        // CORREÇÃO: Usar PDO para buscar imagens antes de apagar
        $stmt = $this->db->prepare("SELECT image_url, image_url2, image_url3 FROM balloonproduct WHERE id = ?");
        $stmt->execute([$id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach ($row as $img) {
                $path = __DIR__ . '/../../public/' . $img;
                if ($img && $img !== 'default.png' && file_exists($path)) unlink($path);
            }
        }
        $stmtDel = $this->db->prepare("DELETE FROM balloonproduct WHERE id = ?");
        return $stmtDel->execute([$id]);
    }

    public function update($data, $files = []) {
        // Primeiro, buscamos os dados atuais para não perder as imagens se não enviar novas
        $stmt = $this->db->prepare("SELECT image_url, image_url2, image_url3 FROM balloonproduct WHERE id = ?");
        $stmt->execute([$data['id']]);
        $atual = $stmt->fetch(PDO::FETCH_ASSOC);

        $images = [$atual['image_url'], $atual['image_url2'], $atual['image_url3']];
        $uploadDir = __DIR__ . '/../../public/uploads/';
        $fileKeys = ['image_file', 'image_file2', 'image_file3'];

        foreach ($fileKeys as $index => $key) {
            if (isset($files[$key]) && $files[$key]['error'] === UPLOAD_ERR_OK) {
                $newName = "img_" . uniqid() . "." . pathinfo($files[$key]['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($files[$key]['tmp_name'], $uploadDir . $newName)) {
                    $images[$index] = "uploads/" . $newName;
                }
            }
        }

        $sql = "UPDATE balloonproduct SET name = ?, category = ?, is_active = ?, description = ?, 
                image_url = ?, image_url2 = ?, image_url3 = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'], $data['category'], $data['is_active'], $data['description'],
            $images[0], $images[1], $images[2], $data['id']
        ]);
    }

public function getById($id) {
        $sql = "SELECT p.*, s.min_value 
                FROM balloonproduct p 
                LEFT JOIN services s ON p.category = s.service_name 
                WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}