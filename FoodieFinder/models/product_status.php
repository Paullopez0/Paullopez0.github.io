<?php

class ProductStatus {
    private $db;
    
    public $id;
    public $shop_id;
    public $customer_id;
    public $product_id;
    public $status;
    public $completion;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create() {
        $query = "INSERT INTO product_status (shop_id, customer_id, product_id, status, completion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->shop_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $this->customer_id, PDO::PARAM_INT);
        $stmt->bindValue(3, $this->product_id, PDO::PARAM_INT);
        $stmt->bindValue(4, 'Pending', PDO::PARAM_STR);
        $stmt->bindValue(5, 0, PDO::PARAM_INT); // Set completion to 0
        return $stmt->execute();
    }

    public function getProductStatusByShop() { 
        $query = "SELECT 
                    ps.id AS product_status_id, ps.status, ps.completion,
                    m.product_name, m.description, m.price,
                    c.profile_picture, c.email
                  FROM product_status ps
                  JOIN menu m ON ps.product_id = m.id
                  JOIN users c ON ps.customer_id= c.id
                  WHERE ps.shop_id = :shop_id";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':shop_id', $this->shop_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }

    public function updateStatus() {
        $query = "UPDATE product_status SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateCompletion() {
        $query = "UPDATE product_status SET completion = :completion WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':completion', $this->completion, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>