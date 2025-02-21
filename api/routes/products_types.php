<?php
require '../core/database.php';
require '../core/response.php';
require '../core/functions.php';

$pdo = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM products_types WHERE removed = FALSE");
        $products_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        sendResponse(200, $products_types);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['name']) || !isset($input['product_tax'])) {
            sendResponse(400, ["error" => "Nome e imposto pago são obrigatórios"]);
        }

        $stmt = $pdo->prepare("INSERT INTO products_types (id, name, product_tax) VALUES (?, ?, ?)");
        $stmt->execute([generateRandomId(), $input['name'], $input['product_tax']]);
        sendResponse(201, ["message" => "Tipo de produto criado com sucesso"]);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendResponse(400, ["error" => "Tipo de produto não encontrado"]);
        } else if (!isset($input['name']) || !isset($input['product_tax'])) {
            sendResponse(400, ["error" => "Nome e imposto pago são obrigatórios"]);
        }

        $stmt = $pdo->prepare("UPDATE products_types SET name = ?, product_tax = ? WHERE id = ?");
        $stmt->execute([$input['name'], $input['product_tax'], $input['id']]);
        sendResponse(200, ["message" => "Tipo de produto atualizado com sucesso"]);
        break;

    case 'DELETE':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendResponse(400, ["error" => "Tipo de produto não encontrado"]);
        }

        $stmt = $pdo->prepare("UPDATE products_types SET removed = TRUE WHERE id = ?");
        $stmt->execute([$input['id']]);
        sendResponse(200, ["message" => "Tipo de produto removido com sucesso"]);
        break;

    default:
        sendResponse(405, ["error" => "Método não permitido"]);
}
