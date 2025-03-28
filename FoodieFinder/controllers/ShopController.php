<?php

require_once './models/shop.php';

class ShopController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($shop_name, $shop_address, $opening_time, $closing_time, $shop_description, $shop_category, $owner_id, $bir_certificate, $mayors_permit, $dti_certificate, $official_logo, $bank_account, $collection_receipt) {
        $shop = new Shop($this->db);

        $result = $shop->createWithDocuments(
            $shop_name,
            $shop_address,
            $opening_time,
            $closing_time,
            $shop_description,
            $shop_category,
            $owner_id,
            $bir_certificate,
            $mayors_permit,
            $dti_certificate,
            $official_logo,
            $bank_account,
            $collection_receipt
        );

        if ($result["status"] === 201) {
            $shop_id = $this->db->lastInsertId();

            return [
                "status" => 201,
                "message" => "Shop created successfully.",
                "id" => $shop_id
            ];
        }

        return [
            "status" => $result["status"],
            "message" => $result["message"]
        ];
    }

    public function getShopInformation($shop_id) {
        $shop = new Shop($this->db);
        return $shop->getShopInformation($shop_id);
    }

    public function getAllShops() {
        $shop = new Shop($this->db);
        return $shop->getAllShops();
    }
}
?>