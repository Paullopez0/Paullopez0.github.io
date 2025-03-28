<?php

class shop_owners {
    private $conn;
    private $table = 'shop_owners';

    public $id;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function emailExists() {
        $query = 'SELECT id FROM ' . $this->table . ' WHERE email = :email LIMIT 1';
        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(':email', $this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function create() {
        if ($this->emailExists()) {
            printf("Error: Email already exists.\n");
            return false;
        }

        $query = 'INSERT INTO ' . $this->table . ' SET email = :email, password = :password';
        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function getShopIdByOwnerId($ownerId) {
        $query = 'SELECT id FROM shop WHERE owner_id = :ownerId LIMIT 1';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':ownerId', $ownerId);

        $stmt->execute();

        $shop = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($shop) {
            return $shop['id'];
        }

        return null;
    }
}

?>