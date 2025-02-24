<?php

class ListProductsTypesQuery {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError() {
        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute() {
        $sql = $this->pdo->query("SELECT id, name, product_tax AS producttax, removed FROM products_types");
        $productsTypes = $sql->fetchAll(PDO::FETCH_ASSOC);

        return ["status" => 200, "data" => $productsTypes];
    }
}