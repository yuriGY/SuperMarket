<?php
require '../Core/database.php';
require '../Core/response.php';
require '../Core/functions.php';

require '../Controllers/ProductsController.php';
require '../Controllers/ProductsTypesController.php';
require '../Controllers/SalesController.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $inputData = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        sendResponse(400, ['error' => 'Dados JSON inválidos']);
        exit;
    }
} else {
    $inputData = null;
}

$pdo = getDbConnection();

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($request_uri, '/'));

$resource = $segments[0] ?? null;
$id = $segments[1] ?? null;

$method = $_SERVER['REQUEST_METHOD'];

switch ($resource) {
    case 'products':
        $controller = new ProductsController($pdo);
        break;
    case 'products_types':
        $controller = new ProductsTypesController($pdo);
        break;
    case 'sales':
        $controller = new SalesController($pdo);
        break;
    default:
        sendResponse(404, ["error" => "Recurso não encontrado"]);
        exit;
}

$controller->handleRequest($method, $inputData, $id);