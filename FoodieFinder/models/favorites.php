<?php

class Favorites {
    private $db;

    public $id;
    public $customer_id;
    public $product_id;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create() {
        $query = "INSERT INTO favorites (customer_id, product_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->customer_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $this->product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getFavoritesByCustomer() {
        $query = "SELECT 
                    f.id AS favorite_id, f.product_id,
                    m.product_name, m.description, m.price, m.image
                  FROM favorites f
                  JOIN menu m ON f.product_id = m.id
                  WHERE f.customer_id = :customer_id";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customer_id', $this->customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }
    
    public function delete() {
        $query = "DELETE FROM favorites WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>