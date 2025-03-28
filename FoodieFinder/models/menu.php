<?php

class Menu {
    private $conn;
    private $table = 'menu';

    public $id;
    public $shop_id;
    public $product_name;
    public $price;
    public $description;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($shop_id, $product_name, $price, $description, $image) {
        $uploadDir = 'documents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imagePath = $uploadDir . uniqid() . '_' . basename($image['name']);

        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            $stmt = $this->conn->prepare("INSERT INTO menu (shop_id, product_name, price, description, image) VALUES (:shop_id, :product_name, :price, :description, :image)");

            try {
                $stmt->bindParam(':shop_id', $shop_id);
                $stmt->bindParam(':product_name', $product_name);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image', $imagePath);
                $stmt->execute();
                return ["status" => 201, "message" => "Shop created successfully"];
            } catch (PDOException $e) {
                return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
            }
        } else {
            return ["status" => 500, "message" => "Failed to upload image."];
        }
    }

    public function getShopMenu($shop_id) {
        $query = "SELECT * FROM menu WHERE shop_id = :shop_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':shop_id', $shop_id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/FoodieFinder/';
    
            $documentFields = [
                'image'
            ];
    
            // Iterate through each row in the documents array
            foreach ($documents as &$document) {
                foreach ($documentFields as $field) {
                    if (isset($document[$field]) && !empty($document[$field])) {
                        $document[$field] = $baseUrl . $document[$field];
                    }
                }
            }
    
            return [
                "status" => 200,
                "data" => $documents
            ];
        } else {
            return [
                "status" => 404,
                "message" => "Menu not found."
            ];
        }
    }

    public function getProduct($id) {
        $query = "SELECT * FROM menu WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $documents = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/FoodieFinder/';
    
            $documentFields = [
                'image'
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
                "message" => "Product not found."
            ];
        }
    }

    public function updateProduct($id, $product_name, $price, $description, $image = null) {
        $query = "UPDATE menu SET product_name = :product_name, price = :price, description = :description";
        if ($image) {
            $uploadDir = 'documents/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imagePath = $uploadDir . uniqid() . '_' . basename($image['name']);
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                $query .= ", image = :image";
            } else {
                return ["status" => 500, "message" => "Failed to upload image."];
            }
        }
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        try {
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            if ($image) {
                $stmt->bindParam(':image', $imagePath);
            }
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return ["status" => 200, "message" => "Product updated successfully"];
        } catch (PDOException $e) {
            return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
        }
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM menu WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        try {
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return ["status" => 200, "message" => "Product deleted successfully"];
        } catch (PDOException $e) {
            return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
        }
    }
}

?>