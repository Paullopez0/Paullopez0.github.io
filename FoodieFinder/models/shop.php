<?php

class Shop {
    private $conn;
    private $table = 'shop';

    public $id;
    public $owner_id;
    public $shop_name;
    public $shop_address;
    public $opening_time;
    public $closing_time;
    public $shop_description;
    public $shop_category;
    public $bir_certificate;
    public $mayors_permit;
    public $dti_certificate;
    public $official_logo;
    public $bank_account;
    public $collection_receipt;


    public function __construct($db) {
        $this->conn = $db;
    }

    public function shopExists() {
        $query = "SELECT id FROM {$this->table} WHERE shop_name = :shop_name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $this->shop_name = htmlspecialchars(strip_tags($this->shop_name));
        $stmt->bindParam(':shop_name', $this->shop_name);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function createWithDocuments($name, $address, $opening_time, $closing_time, $description, $category, $owner_id, $bir_certificate, $mayors_permit, $dti_certificate, $official_logo, $bank_account, $collection_receipt) {
        $checkOwner = $this->conn->prepare("SELECT id FROM shop_owners WHERE id = :owner_id");
        $checkOwner->bindParam(':owner_id', $owner_id);
        $checkOwner->execute();

        if ($checkOwner->rowCount() == 0) {
            return ["status" => 400, "message" => "Owner ID does not exist!"];
        }

        $this->shop_name = $name;
        if ($this->shopExists()) {
            return ["status" => 400, "message" => "Shop already exists!"];
        }

        $uploadDir = 'documents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $birPath = $uploadDir . uniqid() . '_' . basename($bir_certificate['name']);
        $mayorsPermitPath = $uploadDir . uniqid() . '_' . basename($mayors_permit['name']);
        $dtiPath = $uploadDir . uniqid() . '_' . basename($dti_certificate['name']);
        $logoPath = $uploadDir . uniqid() . '_' . basename($official_logo['name']);
        $bankAccountPath = $uploadDir . uniqid() . '_' . basename($bank_account['name']);
        $collectionReceiptPath = $uploadDir . uniqid() . '_' . basename($collection_receipt['name']);

        if (move_uploaded_file($bir_certificate['tmp_name'], $birPath) &&
            move_uploaded_file($mayors_permit['tmp_name'], $mayorsPermitPath) &&
            move_uploaded_file($dti_certificate['tmp_name'], $dtiPath) &&
            move_uploaded_file($official_logo['tmp_name'], $logoPath) &&
            move_uploaded_file($bank_account['tmp_name'], $bankAccountPath) &&
            move_uploaded_file($collection_receipt['tmp_name'], $collectionReceiptPath)) {

            $stmt = $this->conn->prepare("INSERT INTO shop (shop_name, shop_address, opening_time, closing_time, shop_description, shop_category, owner_id, bir_certificate, mayors_permit, dti_certificate, official_logo, bank_account, collection_receipt) VALUES (:shop_name, :shop_address, :opening_time, :closing_time, :shop_description, :shop_category, :owner_id, :bir_certificate, :mayors_permit, :dti_certificate, :official_logo, :bank_account, :collection_receipt)");

            try {
                $stmt->bindParam(':shop_name', $name);
                $stmt->bindParam(':shop_address', $address);
                $stmt->bindParam(':opening_time', $opening_time);
                $stmt->bindParam(':closing_time', $closing_time); 
                $stmt->bindParam(':shop_description', $description);
                $stmt->bindParam(':shop_category', $category);
                $stmt->bindParam(':owner_id', $owner_id);
                $stmt->bindParam(':bir_certificate', $birPath);
                $stmt->bindParam(':mayors_permit', $mayorsPermitPath);
                $stmt->bindParam(':dti_certificate', $dtiPath);
                $stmt->bindParam(':official_logo', $logoPath);
                $stmt->bindParam(':bank_account', $bankAccountPath);
                $stmt->bindParam(':collection_receipt', $collectionReceiptPath);
                $stmt->execute();
                return ["status" => 201, "message" => "Shop created successfully"];
            } catch (PDOException $e) {
                return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
            }
        } else {
            return ["status" => 500, "message" => "Failed to upload files"];
        }
    }

    public function getShopInformation($shop_id) {
        $query = "SELECT s.*, so.email 
                  FROM shop s
                  JOIN shop_owners so ON s.owner_id = so.id
                  WHERE s.id = :shop_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':shop_id', $shop_id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $documents = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/FoodieFinder/';
    
            $documentFields = [
                'bir_certificate',
                'mayors_permit',
                'dti_certificate',
                'official_logo',
                'bank_account',
                'collection_receipt'
            ];
    
            foreach ($documents as $key => $value) {
                if (in_array($key, $documentFields)) {
                    $documents[$key] = $baseUrl . $value;
                }
            }
    
            return [
                "status" => 200,
                "data" => $documents
            ];
        } else {
            return [
                "status" => 404,
                "message" => "Shop not found."
            ];
        }
    }

    public function getAllShops() {
        $query = "SELECT s.*, so.email 
                  FROM shop s
                  JOIN shop_owners so ON s.owner_id = so.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $shops = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/FoodieFinder/';
    
            $documentFields = [
                'bir_certificate',
                'mayors_permit',
                'dti_certificate',
                'official_logo',
                'bank_account',
                'collection_receipt'
            ];
    
            foreach ($shops as &$shop) {
                foreach ($shop as $key => $value) {
                    if (in_array($key, $documentFields)) {
                        $shop[$key] = $baseUrl . $value;
                    }
                }
            }
    
            return [
                "status" => 200,
                "data" => $shops
            ];
        } else {
            return [
                "status" => 404,
                "message" => "No shops found."
            ];
        }
    }
    public function countShops() {
        $query = "SELECT COUNT(*) as total_shops FROM shop";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_shops'] ?? 0;
    }
}

?>
