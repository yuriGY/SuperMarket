<?php
$usersFile = '../data/users.json';

$users = json_decode(file_get_contents($usersFile), true);

switch ($method) {
    case 'GET':
        sendResponse(200, $users);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['name']) || !isset($input['email'])) {
            sendResponse(400, ["error" => "Nome e e-mail são obrigatórios"]);
        }
        $newUser = [
            "id" => count($users) + 1,
            "name" => $input['name'],
            "email" => $input['email']
        ];
        $users[] = $newUser;
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
        sendResponse(201, $newUser);
        break;

    default:
        sendResponse(405, ["error" => "Método não permitido"]);
        break;
}
