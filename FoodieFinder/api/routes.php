<?php
require_once './config/Database.php';
require_once './controllers/UserController.php';
require_once './controllers/ShopOwnerController.php';
require_once './controllers/ShopController.php';

$db = (new Database())->connect();
$userController = new UserController($db);
$shopownerController = new ShopOwnerController($db);
$shopController = new ShopController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'sign-up') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
        $input = $_POST;
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json or application/x-www-form-urlencoded."
        ]);
        exit;
    }

    if (!$input) {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid input or malformed JSON."
        ]);
        exit;
    }

    if (empty($input['email']) || empty($input['password'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields: email, password."
        ]);
        exit;
    }

    $response = $userController->signUp($input['email'], $input['password']);
    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'login') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
        $input = $_POST;
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json or application/x-www-form-urlencoded."
        ]);
        exit;
    }

    if (empty($input['email']) || empty($input['password'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Email and password are required."
        ]);
        exit;
    }

    $response = $userController->login($input['email'], $input['password']);
    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'shopowner_sign-up') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
        $input = $_POST;
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json or application/x-www-form-urlencoded."
        ]);
        exit;
    }

    if (!$input) {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid input or malformed JSON."
        ]);
        exit;
    }

    if (empty($input['email']) || empty($input['password'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields: email, password."
        ]);
        exit;
    }

    $response = $shopownerController->signup($input['email'], $input['password']);
    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'shopowner_login') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
        $input = $_POST;
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json or application/x-www-form-urlencoded."
        ]);
        exit;
    }

    if (empty($input['email']) || empty($input['password'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Email and password are required."
        ]);
        exit;
    }

    $response = $shopownerController->login($input['email'], $input['password']);
    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'registration') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
        $input = $_POST;
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json or application/x-www-form-urlencoded."
        ]);
        exit;
    }

    if (empty($input['shop_name']) || empty($input['shop_address']) || empty($input['shop_description']) || empty($input['shop_category']) || empty($input['shop_owner_id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields"
        ]);
        exit;
    }
    $owner_id = $input['shop_owner_id'] ?? null;
    if ($owner_id === null) {
        echo json_encode(["status" => 400, "message" => "Owner ID is required."]);
        exit;
    }

    $checkOwner = $db->prepare("SELECT id FROM shop_owners WHERE id = ?");
    $checkOwner->execute([$owner_id]);

    if ($checkOwner->rowCount() == 0) {
        echo json_encode(["status" => 400, "message" => "Owner ID does not exist."]);
        exit;
    }

    // Create shop record
    $response = $shopController->create(
        $input['shop_name'],
        $input['shop_address'],
        $input['shop_description'],
        $input['shop_category'],
        $owner_id
    );

    // Send response with proper HTTP status code
    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

echo json_encode([
    "status" => 404,
    "message" => "Route not found or invalid request method."
]);
exit;
?>