<?php
require '../core/database.php';
require '../core/response.php';
require '../core/functions.php';

$pdo = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM products WHERE removed = FALSE");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        sendResponse(200, $products);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['name']) || !isset($input['product_type_id']) || !isset($input['stock'])) {
            sendResponse(400, ["error" => "Nome, tipo e quantidade em estoque são obrigatórios"]);
        }

        $stmt = $pdo->prepare("INSERT INTO products (id, name, product_type_id, stock) VALUES (?, ?, ?, ?)");
        $stmt->execute([generateRandomId(), $input['name'], $input['product_type_id'], $input['stock']]);
        sendResponse(201, ["message" => "Produto criado com sucesso"]);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendResponse(400, ["error" => "Produto não encontrado"]);
        } else if (!isset($input['name']) || !isset($input['product_type_id']) || !isset($input['stock'])) {
            sendResponse(400, ["error" => "Nome, tipo e quantidade em estoque são obrigatórios"]);
        }

        $stmt = $pdo->prepare("UPDATE products SET name = ?, product_type_id = ?, stock = ? WHERE id = ?");
        $stmt->execute([$input['name'], $input['product_type_id'], $input['stock'], $input['id']]);
        sendResponse(200, ["message" => "Produto atualizado com sucesso"]);
        break;

    case 'DELETE':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendResponse(400, ["error" => "Produto não encontrado"]);
        }

        $stmt = $pdo->prepare("UPDATE products SET removed = TRUE WHERE id = ?");
        $stmt->execute([$input['id']]);
        sendResponse(200, ["message" => "Produto removido com sucesso"]);
        break;

    default:
        sendResponse(405, ["error" => "Método não permitido"]);
}
