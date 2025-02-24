<?php

class GetProductByIdQuery {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($id) {
        if (empty($id) || strlen($id) !== 8) {
            return ["status" => 400, "message" => "Identificador inválido"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($id) {
        $sql = $this->pdo->prepare("
            SELECT p.id, p.name, pt.name AS typename, p.stock, p.cost, pt.removed AS typeremoved, pt.id AS typeid
            FROM products p
            INNER JOIN products_types pt ON (p.product_type_id = pt.id)
            WHERE p.id = ? AND p.removed = FALSE"
        );
        $sql->execute([$id]);
        $product = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return ["status" => 404, "data" => ["error" => "Produto não encontrado"]];
        }

        return ["status" => 200, "data" => $product];
    }
}