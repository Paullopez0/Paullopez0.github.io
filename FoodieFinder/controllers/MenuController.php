<?php

require_once './models/menu.php';

class MenuController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($shop_id, $product_name, $price, $description, $image) {
        $menu = new Menu($this->db);

        $result = $menu->create(
            $shop_id,
            $product_name,
            $price,
            $description,
            $image
        );

        if ($result["status"] === 201) {
            return [
                "status" => 201,
                "message" => "Product created successfully."
            ];
        }

        return [
            "status" => $result["status"],
            "message" => $result["message"]
        ];
    }

    public function getShopMenu($shop_id) {
        $menu = new Menu($this->db);
        return $menu->getShopMenu($shop_id);
    }

    public function getProduct($id) {
        $menu = new Menu($this->db);
        return $menu->getProduct($id);
    }

    public function updateProduct($id, $product_name, $price, $description, $image = null) {
        $menu = new Menu($this->db);

        $result = $menu->updateProduct(
            $id,
            $product_name,
            $price,
            $description,
            $image
        );

        if ($result["status"] === 200) {
            return [
                "status" => 200,
                "message" => "Product updated successfully."
            ];
        }

        return [
            "status" => $result["status"],
            "message" => $result["message"]
        ];
    }

    public function deleteProduct($id) {
        $menu = new Menu($this->db);

        $result = $menu->deleteProduct($id);

        if ($result["status"] === 200) {
            return [
                "status" => 200,
                "message" => "Product deleted successfully."
            ];
        }

        return [
            "status" => $result["status"],
            "message" => $result["message"]
        ];
    }
}

?>