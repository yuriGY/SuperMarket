<?php

require_once '../Core/response.php';
require_once '../Core/RequestHandler.php';
require_once '../Commands/Sales/MakeSaleCommand.php';
require_once '../Queries/Sales/CheckoutQuery.php';

class SalesController {
    private $pdo;
    private $requestHandler;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->requestHandler = new RequestHandler($pdo);
    }

    public function handleRequest($method, $input, $id = null) {
        switch ($method) {
            case 'GET':
                $result = $this->requestHandler->handle(new CheckoutQuery($this->pdo), [$id]);
                sendResponse($result['status'], $result['data']);
                break;

            case 'POST':
                $result = $this->requestHandler->handle(new MakeSaleCommand($this->pdo), [$input]);
                sendResponse($result['status'], $result['data']);
                break;

            default:
                sendResponse(405, ["error" => "Método não permitido"]);
        }
    }
}
