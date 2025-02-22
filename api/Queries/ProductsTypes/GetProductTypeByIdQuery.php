<?php

class GetProductTypeByIdQuery {
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
        $sql = $this->pdo->prepare("SELECT id, name, product_tax FROM products_types WHERE id = ? AND removed = FALSE");
        $sql->execute([$id]);
        $productType = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$productType) {
            return ["status" => 404, "data" => ["error" => "Produto não encontrado"]];
        }

        return ["status" => 200, "data" => $productType];
    }
}