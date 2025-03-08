<?php

class Shop {
    private $conn;
    private $table = 'shop';

    public $id;
    public $owner_id;
    public $shop_name;
    public $shop_address;
    public $shop_description;
    public $shop_category;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Check if a shop with the same name already exists
    public function shopExists() {
        $query = "SELECT id FROM {$this->table} WHERE shop_name = :shop_name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $this->shop_name = htmlspecialchars(strip_tags($this->shop_name));
        $stmt->bindParam(':shop_name', $this->shop_name);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Create a new shop
    public function create($name, $address, $description, $category, $owner_id) {
        // Check if owner exists
        $checkOwner = $this->conn->prepare("SELECT id FROM shop_owners WHERE id = ?");
        $checkOwner->execute([$owner_id]);

        if ($checkOwner->rowCount() == 0) {
            return ["status" => 400, "message" => "Owner ID does not exist!"];
        }

        // Check if shop already exists
        $this->shop_name = $name;
        if ($this->shopExists()) {
            return ["status" => 400, "message" => "Shop already exists!"];
        }

        // Insert shop into database
        $stmt = $this->conn->prepare("INSERT INTO shop (shop_name, shop_address, shop_description, shop_category, owner_id) VALUES (?, ?, ?, ?, ?)");

        try {
            $stmt->execute([$name, $address, $description, $category, $owner_id]);
            return ["status" => 201, "message" => "Shop created successfully"];
        } catch (PDOException $e) {
            return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
        }
    }
}

?>
