<?php
header("Content-Type: application/json");

require_once '../core/response.php';

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($request_uri) {
    case '/users':
        require '../routes/users.php';
        break;

    case '/products_types':
        require '../routes/products_types.php';
        break;

    case '/products':
        require '../routes/products.php';
        break;

    default:
        sendResponse(404, ["error" => "Rota não encontrada"]);
        break;
}
