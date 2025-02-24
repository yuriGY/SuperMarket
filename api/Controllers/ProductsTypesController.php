<?php

require_once '../Core/response.php';
require_once '../Core/RequestHandler.php';
require_once '../Commands/ProductsTypes/CreateProductTypeCommand.php';
require_once '../Commands/ProductsTypes/UpdateProductTypeCommand.php';
require_once '../Commands/ProductsTypes/RemoveProductTypeCommand.php';
require_once '../Queries/ProductsTypes/ListProductsTypesQuery.php';
require_once '../Queries/ProductsTypes/GetProductTypeByIdQuery.php';

class ProductsTypesController {
    private $pdo;
    private $requestHandler;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->requestHandler = new RequestHandler($pdo);
    }

    public function handleRequest($method, $input, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->requestHandler->handle(new GetProductTypeByIdQuery($this->pdo), [$id]);
                } else {
                    $result = $this->requestHandler->handle(new ListProductsTypesQuery($this->pdo));
                }
                sendResponse($result['status'], $result['data']);
                break;

            case 'POST':
                $result = $this->requestHandler->handle(new CreateProductTypeCommand($this->pdo), [$input]);
                sendResponse($result['status'], $result['data']);
                break;

            case 'PUT':
                $result = $this->requestHandler->handle(new UpdateProductTypeCommand($this->pdo), [$id, $input]);
                sendResponse($result['status'], $result['data']);
                break;

            case 'DELETE':
                $result = $this->requestHandler->handle(new RemoveProductTypeCommand($this->pdo), [$id]);
                sendResponse($result['status'], $result['data']);
                break;

            default:
                sendResponse(405, ["error" => "Método não permitido"]);
        }
    }
}
