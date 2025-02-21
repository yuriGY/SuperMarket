<?php
require '../core/database.php';
require '../core/response.php';
require '../core/functions.php';

$pdo = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT id, name, user_type_id, register_date, email FROM users WHERE removed = FALSE");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        sendResponse(200, $users);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['name']) || !isset($input['email']) || !isset($input['password'])) {
            sendResponse(400, ["error" => "Nome, e-mail e senha são obrigatórios, favor preencher"]);
        }

        $stmt = $pdo->prepare("INSERT INTO users (id, name, email, password, user_type_id, register_date) 
                                VALUES (?, ?, ?, ?, 'P5d1E6f8', NOW())");
        $stmt->execute([generateRandomId(), $input['name'], $input['email'], password_hash($input['password'], PASSWORD_DEFAULT)]);
        sendResponse(201, ["message" => "Usuário criado com sucesso"]);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendResponse(400, ["error" => "Usuário não encontrado"]);
        } else if (!isset($input['name']) || !isset($input['email'])) {
            sendResponse(400, ["error" => "Nome e e-mail são obrigatórios, favor preencher"]); 
        }

        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$input['name'], $input['email'], $input['id']]);
        sendResponse(200, ["message" => "Usuário atualizado com sucesso"]);
        break;

    case 'DELETE':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendResponse(400, ["error" => "Usuário não encontrado"]);
        }

        $stmt = $pdo->prepare("UPDATE users SET removed = TRUE WHERE id = ?");
        $stmt->execute([$input['id']]);
        sendResponse(200, ["message" => "Usuário removido com sucesso"]);
        break;

    default:
        sendResponse(405, ["error" => "Método não permitido"]);
}
