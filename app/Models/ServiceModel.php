<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class ServiceModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

   public function getAll() {
    $db = \App\Core\Database::getConnection();
    // Use 'services' em minúsculo para o InfinityFree
    $query = $db->query("SELECT * FROM services ORDER BY service_name ASC"); 
    return $query->fetchAll();
}

    public function getSettings() {
        $stmt = $this->db->query("SELECT * FROM settings WHERE id = 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data) {
        $sql = "INSERT INTO services (service_name, min_value, service_description) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            trim($data['service_name']),
            str_replace(',', '.', (string)$data['min_value']),
            trim($data['service_description'])
        ]);
    }

    public function update($data) {
        $sql = "UPDATE services SET service_name = ?, min_value = ?, service_description = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['service_name'],
            str_replace(',', '.', (string)$data['min_value']),
            $data['service_description'],
            $data['id']
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM services WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

public function saveSettings($hourly, $markup, $whatsapp) {
    // Garante que o WhatsApp seja apenas números
    $whatsapp = preg_replace('/\D/', '', (string)$whatsapp);
    
    // Converte vírgula em ponto e força o valor a ser numérico (float)
    $hourly = (float)str_replace(',', '.', (string)$hourly);
    $markup = (float)str_replace(',', '.', (string)$markup);

    $sql = "UPDATE settings SET 
            default_hourly_rate = ?, 
            default_markup_percentage = ?, 
            whatsapp_number = ? 
            WHERE id = 1";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$hourly, $markup, $whatsapp]);
}
}