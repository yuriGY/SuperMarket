<?php

class UpdateProductTypeCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($id, $input) {
        if (!isset($input['name']) || !isset($input['product_tax'])) {
            return ["error" => "Nome e imposto pago são obrigatórios"];
        }

        $sql = $this->pdo->prepare("UPDATE products_types SET name = ?, product_tax = ? WHERE id = ?");
        $sql->execute([$input['name'], $input['product_tax'], $id]);
        return ["message" => "Tipo de produto atualizado com sucesso"];
    }
}