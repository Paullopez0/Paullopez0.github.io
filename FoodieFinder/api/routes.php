<?php
require_once './config/Database.php';
require_once './controllers/UserController.php';
require_once './controllers/ShopOwnerController.php';
require_once './controllers/ShopController.php';
require_once './controllers/MenuController.php';
require_once './controllers/ProductStatusController.php';
require_once './controllers/FavoritesController.php';
require_once './controllers/BingoController.php';
require_once './controllers/AdminController.php';

$db = (new Database())->connect();
$userController = new UserController($db);
$shopownerController = new ShopOwnerController($db);
$shopController = new ShopController($db);
$menuController = new MenuController($db);
$productStatusController = new ProductStatusController($db);
$favoritesController = new FavoritesController($db);
$bingoController = new BingoController($db);
$adminController = new AdminController($db);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'sign_up') {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === '_login') {
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'admin-login') {
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

    $response = $adminController->login($input['email'], $input['password']);
    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'shop-registration') {
    if (empty($_POST['owner_id']) || empty($_POST['shop_name']) || empty($_POST['shop_address']) || empty($_POST['opening_time']) || empty($_POST['closing_time']) || empty($_POST['shop_description']) || empty($_POST['shop_category']) || empty($_FILES['bir_certificate']) || empty($_FILES['mayors_permit']) || empty($_FILES['dti_certificate']) || empty($_FILES['official_logo']) || empty($_FILES['bank_account']) || empty($_FILES['collection_receipt'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    $response = $shopController->create(
        $_POST['shop_name'],
        $_POST['shop_address'],
        $_POST['opening_time'],
        $_POST['closing_time'],
        $_POST['shop_description'],
        $_POST['shop_category'],
        $_POST['owner_id'],
        $_FILES['bir_certificate'],
        $_FILES['mayors_permit'],
        $_FILES['dti_certificate'],
        $_FILES['official_logo'],
        $_FILES['bank_account'],
        $_FILES['collection_receipt']
    );

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route']) && $_GET['route'] === 'shop-get-info') {
    if (empty($_GET['shop_id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required field: shop_id"
        ]);
        exit;
    }

    $response = $shopController->getShopInformation($_GET['shop_id']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route']) && $_GET['route'] === 'shops') {
    $response = $shopController->getAllShops();
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'create-menu') {
    if (empty($_POST['shop_id']) || empty($_POST['product_name']) || empty($_POST['price']) || empty($_POST['description']) || empty($_FILES['image'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    $response = $menuController->create(
        $_POST['shop_id'],
        $_POST['product_name'],
        $_POST['price'],
        $_POST['description'],
        $_FILES['image']
    );

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route']) && $_GET['route'] === 'shop-get-menu') {
    if (empty($_GET['shop_id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required field: shop_id"
        ]);
        exit;
    }

    $response = $menuController->getShopMenu($_GET['shop_id']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route']) && $_GET['route'] === 'product') {
    if (empty($_GET['id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing product id"
        ]);
        exit;
    }

    $response = $menuController->getProduct($_GET['id']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'update-product') {
    if (empty($_POST['id']) || empty($_POST['product_name']) || empty($_POST['price']) || empty($_POST['description'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    $response = $menuController->updateProduct(
        $_POST['id'],
        $_POST['product_name'],
        $_POST['price'],
        $_POST['description'],
        $image
    );

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'delete-product') {
    if (empty($_POST['id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required field: id"
        ]);
        exit;
    }

    $response = $menuController->deleteProduct($_POST['id']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'create-order') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json."
        ]);
        exit;
    }

    if (empty($input['shop_id']) || empty($input['customer_id']) || empty($input['product_id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    $response = $productStatusController->create(
        $input['shop_id'],
        $input['customer_id'],
        $input['product_id'],
    );

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route']) && $_GET['route'] === 'shop-product-status') {
    if (empty($_GET['shop_id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required field: shop_id"
        ]);
        exit;
    }

    $response = $productStatusController->getProductStatusByShop($_GET['shop_id']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['route']) && $_GET['route'] === 'update-status') {
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

    if (empty($input['id']) || empty($input['status'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields: id, status."
        ]);
        exit;
    }

    $productStatusController = new ProductStatusController($db);
    $response = $productStatusController->updateStatus($input['id'], $input['status']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['route']) && $_GET['route'] === 'update-completion') {
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

    if (empty($input['id']) || empty($input['completion'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields: id, completion."
        ]);
        exit;
    }

    $productStatusController = new ProductStatusController($db);
    $response = $productStatusController->updateCompletion($input['id'], $input['completion']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'add-favorite') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json."
        ]);
        exit;
    }

    if (empty($input['customer_id']) || empty($input['product_id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    $response = $favoritesController->create(
        $input['customer_id'],
        $input['product_id'],
    );

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route']) && $_GET['route'] === 'get-favorites') {
    if (empty($_GET['customer_id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required field: shop_id"
        ]);
        exit;
    }

    $response = $favoritesController->getFavoritesByCustomer($_GET['customer_id']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['route']) && $_GET['route'] === 'delete-favorite') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid Content-Type. Use application/json."
        ]);
        exit;
    }

    if (empty($input['id'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required field: id"
        ]);
        exit;
    }

    $response = $favoritesController->delete($input['id']);

    http_response_code($response['status']);
    echo json_encode($response);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'bingo') {
    if (empty($_POST['shop_id']) || empty($_FILES['item1']) || empty($_FILES['item2']) || empty($_FILES['item3']) || empty($_FILES['item4']) || empty($_FILES['item5']) || empty($_FILES['item6']) || empty($_FILES['item7']) || empty($_FILES['item8']) || empty($_FILES['item9'])) {
        echo json_encode([
            "status" => 400,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    $response = $bingoController->create(
        $_POST['shop_id'],
        $_FILES['item1'],
        $_FILES['item2'],
        $_FILES['item3'],
        $_FILES['item4'],
        $_FILES['item5'],
        $_FILES['item6'],
        $_FILES['item7'],
        $_FILES['item8'],
        $_FILES['item9']
    );

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