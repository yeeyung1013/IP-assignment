<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */

class TicketInputValidator {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function validateTicketInput($data,$isUpdate = false) {
        $errors = [];

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
            $errors[] = 'Price must be a positive number.';
        }

        if (!isset($data['slot']) || !is_numeric($data['slot']) || $data['slot'] < 0) {
            $errors[] = 'Slot must be a non-negative number.';
        }

        if (!isset($data['slot_sold']) || !is_numeric($data['slot_sold']) || $data['slot_sold'] < 0) {
            $errors[] = 'Slot Sold must be a non-negative number.';
        }

        $validCategories = ['Standard', 'VIP', 'VVIP', 'SuperVIP'];
        if (!isset($data['category']) || !in_array($data['category'], $validCategories)) {
            $errors[] = 'Invalid ticket category.';
        } elseif(!$isUpdate) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM ticket WHERE schedule_id = ? AND category = ?");
            $stmt->execute([$data['schedule_id'], $data['category']]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = 'This category already exists for the selected schedule. Please delete the existing ticket first.';
            }
        }

        if (empty($data['image']['name']) && !$isUpdate) { 
            $errors[] = 'Image is required.';
        } elseif (!empty($data['image']['name'])) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = pathinfo($data['image']['name'], PATHINFO_EXTENSION);

            if ($data['image']['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'Error uploading image.';
            } elseif (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                $errors[] = 'Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.';
            }
        }

        return $errors;
    }
}