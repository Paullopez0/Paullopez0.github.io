<?php

class admin {
    private $conn;
    private $table = 'admin';

    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to fetch admin details from the database
    public function getAdminDetails() {
        $query = "SELECT email, password FROM " . $this->table . " LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            // Debugging: Log the fetched admin details
            error_log("Admin fetched: " . print_r($admin, true));
            return $admin;
        } else {
            error_log("No admin found in the database.");
            return null;
        }
    }
}
?>