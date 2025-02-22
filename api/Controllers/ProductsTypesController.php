<?php

require_once '../Core/response.php';
require_once '../Commands/ProductsTypes/CreateProductTypeCommand.php';
require_once '../Commands/ProductsTypes/UpdateProductTypeCommand.php';
require_once '../Commands/ProductsTypes/RemoveProductTypeCommand.php';
require_once '../Queries/ProductsTypes/ListProductsTypesQuery.php';
require_once '../Queries/ProductsTypes/GetProductTypeByIdQuery.php';

class ProductsTypesController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $query = new GetProductTypeByIdQuery($this->pdo);
                    $productType = $query->execute($id);
                    if (!$productType) {
                        sendResponse(404, ["error" => "Tipo de produto não encontrado"]);
                    }
                    sendResponse(200, $productType);
                } else {
                    $query = new ListProductsTypesQuery($this->pdo);
                    $productsTypes = $query->execute();
                    sendResponse(200, $productsTypes);
                }
                break;

            case 'POST':
                $input = json_decode(file_get_contents('php://input'), true);
                $command = new CreateProductTypeCommand($this->pdo);
                $result = $command->execute($input);
                sendResponse(201, $result);
                break;

            case 'PUT':
                if (!$id) {
                    sendResponse(400, ["error" => "Identificador inválido"]);
                }
                $input = json_decode(file_get_contents('php://input'), true);
                $command = new UpdateProductTypeCommand($this->pdo);
                $result = $command->execute($id, $input);
                sendResponse(200, $result);
                break;

            case 'DELETE':
                if (!$id) {
                    sendResponse(400, ["error" => "Identificador inválido"]);
                }
                $command = new RemoveProductTypeCommand($this->pdo);
                $result = $command->execute($id);
                sendResponse(200, $result);
                break;

            default:
                sendResponse(405, ["error" => "Método não permitido"]);
        }
    }
}