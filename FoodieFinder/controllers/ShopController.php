<?php

require_once './models/shop.php';

class ShopController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($shop_name, $shop_address, $shop_description, $shop_category, $owner_id) {
        $shop = new Shop($this->db);
        $shop->shop_name = $shop_name;
        $shop->shop_address = $shop_address;
        $shop->shop_description = $shop_description;
        $shop->shop_category = $shop_category;

        if ($shop->shopExists()) {
            return [
                "status" => 400,
                "message" => "Shop already exists."
            ];
        }

        $result = $shop->create($shop_name, $shop_address, $shop_description, $shop_category, $owner_id);
        if ($result["status"] === "success") {
            return [
                "status" => 201,
                "message" => "Shop created successfully."
            ];
        }

        return [
            "status" => 500,
            "message" => $result["message"]
        ];
    }
}
?>