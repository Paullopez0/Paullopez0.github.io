<?php

require_once './models/favorites.php';
class FavoritesController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($customer_id, $product_id) {
        $favorites = new Favorites($this->db);
        $favorites->customer_id = $customer_id;
        $favorites->product_id = $product_id;

        if ($favorites->create()) {
            return [
                "status" => 201,
                "message" => "Favorite created successfully."
            ];
        } else {
            return [
                "status" => 500,
                "message" => "Failed to create favorite."
            ];
        }
    }

    public function getFavoritesByCustomer($customer_id) {
        $favorites = new Favorites($this->db);
        $favorites->customer_id = $customer_id;
        $result = $favorites->getFavoritesByCustomer();

        if ($result) {
            return [
                "status" => 200,
                "data" => $result
            ];
        } else {
            return [
                "status" => 404,
                "message" => "No favorites found for the customer."
            ];
        }
    }

    public function delete($id) {
        $favorites = new Favorites($this->db);
        $favorites->id = $id;

        if ($favorites->delete()) {
            return [
                "status" => 200,
                "message" => "Favorite deleted successfully."
            ];
        } else {
            return [
                "status" => 500,
                "message" => "Failed to delete favorite."
            ];
        }
    }
}

?>