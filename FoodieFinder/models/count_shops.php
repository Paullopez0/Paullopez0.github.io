<?php
// filepath: c:\xampp\htdocs\FFproject\FoodieFinder\api\count_shops.php

require_once '../config/database.php';
require_once '../models/shop.php';

// Initialize database connection
$database = new Database();
$db = $database->connect();

// Initialize Shop model
$shop = new Shop($db);

// Get the total number of shops
$totalShops = $shop->countShops();

header('Content-Type: application/json');
echo json_encode(["status" => 200, "total_shops" => $totalShops]);
?>