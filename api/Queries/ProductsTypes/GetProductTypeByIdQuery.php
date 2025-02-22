<?php

class GetProductTypeByIdQuery {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($id) {
        $stmt = $this->pdo->prepare("SELECT id, name, product_tax FROM products_types WHERE id = ? AND removed = FALSE");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}