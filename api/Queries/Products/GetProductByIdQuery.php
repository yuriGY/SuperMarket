<?php

class GetProductByIdQuery {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($id) {
        $sql = $this->pdo->prepare("SELECT id, name, product_type_id, stock FROM products WHERE id = ? AND removed = FALSE");
        $sql->execute([$id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}
