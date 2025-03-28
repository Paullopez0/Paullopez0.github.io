<?php

require_once './models/bingo.php';

class BingoController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($shop_id, $item1, $item2, $item3, $item4, $item5, $item6, $item7, $item8, $item9) {
        $bingo = new Bingo($this->db);

        $result = $bingo->createBingo(
            $shop_id,
            $item1,
            $item2,
            $item3,
            $item4,
            $item5,
            $item6,
            $item7,
            $item8,
            $item9
        );

        if ($result["status"] === 201) {
            return [
                "status" => 201,
                "message" => "Bingo created successfully.",
                "id" => $this->db->lastInsertId()
            ];
        }

        return [
            "status" => $result["status"],
            "message" => $result["message"]
        ];
    }
}

?>