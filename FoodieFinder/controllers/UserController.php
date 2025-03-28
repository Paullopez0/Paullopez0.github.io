<?php

require_once './models/user.php';

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function signUp($email, $password) {
        $user = new User($this->db);
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_BCRYPT);

        if ($user->emailExists()) {
            return [
                "status" => 400,
                "message" => "Email already exists."
            ];
        }

        if ($user->create()) {
            return [
                "status" => 201,
                "message" => "User created successfully."
            ];
        }

        return [
            "status" => 500,
            "message" => "Unable to create user."
        ];
    }

    public function login($email, $password) {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
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

            $token = bin2hex(random_bytes(32));

            return [
                "status" => 200,
                "message" => "Login successful.",
                "id" => $user['id'],
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