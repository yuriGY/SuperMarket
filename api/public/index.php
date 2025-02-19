<?php
header("Content-Type: application/json");

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

require '../core/response.php';

switch ($request_uri) {
    case '/users':
        require '../routes/users.php';
        break;
    
    default:
        sendResponse(404, ["error" => "Rota não encontrada"]);
        break;
}