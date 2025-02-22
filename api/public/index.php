<?php

require '../Core/database.php';
require '../Core/response.php';
require '../Core/functions.php';

require '../Controllers/ProductsController.php';
require '../Controllers/ProductsTypesController.php';
require '../Controllers/SalesController.php';

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

$controller->handleRequest($method, $id);