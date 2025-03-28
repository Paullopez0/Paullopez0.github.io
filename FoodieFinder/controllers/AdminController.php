<?php
require_once './models/admin.php';

class AdminController{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    
    public function login($email, $password) {
        $admin = new admin($this->db);
        $adminDetails = $admin->getAdminDetails();

        if ($adminDetails && $email === $adminDetails['email'] && $password === $adminDetails['password']) {
            $token = bin2hex(random_bytes(32));

            return [
                "status" => 200,
                "message" => "Admin login successful.",
                "token" => $token
            ];
        }

        return [
            "status" => 401,
            "message" => "Invalid email or password."
        ];
    } 
}
?>