<?php

class ListProductsTypesQuery {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute() {
        $stmt = $this->pdo->query("SELECT id, name, product_tax FROM products_types WHERE removed = FALSE");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}