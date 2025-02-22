<?php

class ListProductsQuery {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute() {
        $sql = $this->pdo->query("SELECT id, name, product_type_id, stock FROM products WHERE removed = FALSE");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}