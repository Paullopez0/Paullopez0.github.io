<?php
require_once './models/shop_owners.php';
class ShopOwnerController{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    public function signup($email, $password) {
        $user = new shop_owners($this->db);
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_BCRYPT);

        if ($user->emailExists()) {
            return [
                "status" => 400,
                "message" => "Email already exists."
            ];
        }

        if ($user->create()) {
            $user->id = $this->db->lastInsertId();
            return [
                "status" => 201,
                "message" => "User created successfully.",
                "id" => $user->id
            ];
        }

        return [
            "status" => 500,
            "message" => "Unable to create user."
        ];
    }

    public function login($email, $password) {
        try {
            error_log("Email: " . $email);
            $query = "SELECT * FROM shop_owners WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':email' => $email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return [
                    "status" => 404,
                    "message" => "User not found."
                ];
            }

            if (!password_verify($password, $user['password'])) {
                return [
                    "status" => 401,
                    "message" => "Invalid email or password."
                ];
            }

            // Get the shop_id using the owner_id
            $shopOwners = new shop_owners($this->db);
            $shopId = $shopOwners->getShopIdByOwnerId($user['id']);

            if (!$shopId) {
                return [
                    "status" => 404,
                    "message" => "Shop not found for this user."
                ];
            }

            $token = bin2hex(random_bytes(32));

            return [
                "status" => 200,
                "message" => "Login successful.",
                "id" => $user['id'],
                "shop_id" => $shopId,
                "token" => $token
            ];
        } catch (PDOException $e) {
            return [
                "status" => 500,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }
}
?>