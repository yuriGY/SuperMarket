<?php

require_once '../Core/response.php';
require_once '../Commands/Products/CreateProductCommand.php';
require_once '../Commands/Products/UpdateProductCommand.php';
require_once '../Commands/Products/RemoveProductCommand.php';
require_once '../Queries/Products/ListProductsQuery.php';
require_once '../Queries/Products/GetProductByIdQuery.php';

class ProductsController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $query = new GetProductByIdQuery($this->pdo);
                    $product = $query->execute($id);
                    if (!$product) {
                        sendResponse(404, ["error" => "Produto não encontrado"]);
                    }
                    sendResponse(200, $product);
                } else {
                    $query = new ListProductsQuery($this->pdo);
                    $products = $query->execute();
                    sendResponse(200, $products);
                }
                break;

            case 'POST':
                $input = json_decode(file_get_contents('php://input'), true);
                $command = new CreateProductCommand($this->pdo);
                $result = $command->execute($input);
                sendResponse(201, $result);
                break;

            case 'PUT':
                if (!$id) {
                    sendResponse(400, ["error" => "Identificador inválido"]);
                }
                $input = json_decode(file_get_contents('php://input'), true);
                $command = new UpdateProductCommand($this->pdo);
                $result = $command->execute($id, $input);
                sendResponse(200, $result);
                break;

            case 'DELETE':
                if (!$id) {
                    sendResponse(400, ["error" => "Identificador inválido"]);
                }
                $command = new RemoveProductCommand($this->pdo);
                $result = $command->execute($id);
                sendResponse(200, $result);
                break;

            default:
                sendResponse(405, ["error" => "Método não permitido"]);
        }
    }
}