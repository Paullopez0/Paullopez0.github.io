<?php

class Bingo {
    private $db;

    public $id;
    public $shop_id;
    public $item1;
    public $item2;
    public $item3;
    public $item4;
    public $item5;
    public $item6;
    public $item7;
    public $item8;
    public $item9;

    public function __construct($db) {
        $this->db = $db;
    }
    public function createBingo($shop_id, $item1, $item2, $item3, $item4, $item5, $item6, $item7, $item8, $item9) {
        $uploadDir = 'bingo_images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $item1Path = $uploadDir . uniqid() . '_' . basename($item1['name']);
        $item2Path = $uploadDir . uniqid() . '_' . basename($item2['name']);
        $item3Path = $uploadDir . uniqid() . '_' . basename($item3['name']);
        $item4Path = $uploadDir . uniqid() . '_' . basename($item4['name']);
        $item5Path = $uploadDir . uniqid() . '_' . basename($item5['name']);
        $item6Path = $uploadDir . uniqid() . '_' . basename($item6['name']);
        $item7Path = $uploadDir . uniqid() . '_' . basename($item7['name']);
        $item8Path = $uploadDir . uniqid() . '_' . basename($item8['name']);
        $item9Path = $uploadDir . uniqid() . '_' . basename($item9['name']);

        if (move_uploaded_file($item1['tmp_name'], $item1Path) &&
            move_uploaded_file($item2['tmp_name'], $item2Path) &&
            move_uploaded_file($item3['tmp_name'], $item3Path) &&
            move_uploaded_file($item4['tmp_name'], $item4Path) &&
            move_uploaded_file($item5['tmp_name'], $item5Path) &&
            move_uploaded_file($item6['tmp_name'], $item6Path) &&
            move_uploaded_file($item7['tmp_name'], $item7Path) &&
            move_uploaded_file($item8['tmp_name'], $item8Path) &&
            move_uploaded_file($item9['tmp_name'], $item9Path)) {

            $stmt = $this->db->prepare("INSERT INTO bingo (shop_id, item1, item2, item3, item4, item5, item6, item7, item8, item9) VALUES (:shop_id, :item1, :item2, :item3, :item4, :item5, :item6, :item7, :item8, :item9)");

            try {
                $stmt->bindParam(':shop_id', $shop_id);
                $stmt->bindParam(':item1', $item1Path);
                $stmt->bindParam(':item2', $item2Path);
                $stmt->bindParam(':item3', $item3Path);
                $stmt->bindParam(':item4', $item4Path);
                $stmt->bindParam(':item5', $item5Path);
                $stmt->bindParam(':item6', $item6Path);
                $stmt->bindParam(':item7', $item7Path);
                $stmt->bindParam(':item8', $item8Path);
                $stmt->bindParam(':item9', $item9Path);
                $stmt->execute();
                return ["status" => 201, "message" => "Bingo created successfully"];
            } catch (PDOException $e) {
                return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
            }
        } else {
            return ["status" => 500, "message" => "Failed to upload files"];
        }
    }
}

?>