<?php

require_once '../Core/response.php';
require_once '../Core/RequestHandler.php';
require_once '../Commands/Products/CreateProductCommand.php';
require_once '../Commands/Products/UpdateProductCommand.php';
require_once '../Commands/Products/RemoveProductCommand.php';
require_once '../Queries/Products/ListProductsQuery.php';
require_once '../Queries/Products/GetProductByIdQuery.php';

class ProductsController {
    private $pdo;
    private $requestHandler;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->requestHandler = new RequestHandler($pdo);
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->requestHandler->handleQuery(new GetProductByIdQuery($this->pdo), [$id]);
                } else {
                    $result = $this->requestHandler->handleQuery(new ListProductsQuery($this->pdo));
                }
                sendResponse($result['status'], $result['data']);
                break;

            case 'POST':
                $input = json_decode(file_get_contents('php://input'), true);
                $result = $this->requestHandler->handleCommand(new CreateProductCommand($this->pdo), [$input]);
                sendResponse($result['status'], $result['data']);
                break;

            case 'PUT':
                $input = json_decode(file_get_contents('php://input'), true);
                $result = $this->requestHandler->handleCommand(new UpdateProductCommand($this->pdo), [$id, $input]);
                sendResponse($result['status'], $result['data']);
                break;

            case 'DELETE':
                $result = $this->requestHandler->handleCommand(new RemoveProductCommand($this->pdo), [$id]);
                sendResponse($result['status'], $result['data']);
                break;

            default:
                sendResponse(405, ["error" => "Método não permitido"]);
        }
    }
}
