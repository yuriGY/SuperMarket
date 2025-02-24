<?php

class ListProductsQuery {
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
        $sql = $this->pdo->query("
            SELECT p.id, p.name, pt.name AS typename, p.stock, p.cost, pt.removed AS typeremoved, pt.product_tax AS tax
            FROM products p
            INNER JOIN products_types pt ON (p.product_type_id = pt.id)
            WHERE p.removed = FALSE"
        );
        $products = $sql->fetchAll(PDO::FETCH_ASSOC);

        return ["status" => 200, "data" => $products];
    }
}