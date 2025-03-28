<?php

require_once './models/product_status.php';

class ProductStatusController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($shop_id, $customer_id, $product_id) {
        $productStatus = new ProductStatus($this->db);
        $productStatus->shop_id = $shop_id;
        $productStatus->customer_id = $customer_id;
        $productStatus->product_id = $product_id;

        if ($productStatus->create()) {
            return [
                "status" => 201,
                "message" => "Product status created successfully."
            ];
        } else {
            return [
                "status" => 500,
                "message" => "Failed to create product status."
            ];
        }
    }

    public function getProductStatusByShop($shop_id) {
        $productStatus = new ProductStatus($this->db);
        $productStatus->shop_id = $shop_id;
        $result = $productStatus->getProductStatusByShop();

        if ($result) {
            return [
                "status" => 200,
                "data" => $result
            ];
        } else {
            return [
                "status" => 404,
                "message" => "No product status found for the shop."
            ];
        }
    }

    public function updateStatus($id, $status) {
        $productStatus = new ProductStatus($this->db);
        $productStatus->id = $id;
        $productStatus->status = $status;

        if ($productStatus->updateStatus()) {
            return [
                "status" => 200,
                "message" => "Product status updated successfully."
            ];
        } else {
            return [
                "status" => 500,
                "message" => "Failed to update product status."
            ];
        }
    }

    public function updateCompletion($id, $completion) {
        $productStatus = new ProductStatus($this->db);
        $productStatus->id = $id;
        $productStatus->completion = $completion;

        if ($productStatus->updateCompletion()) {
            return [
                "status" => 200,
                "message" => "Product status completion updated successfully."
            ];
        } else {
            return [
                "status" => 500,
                "message" => "Failed to update product status completion."
            ];
        }
    }
}

?>