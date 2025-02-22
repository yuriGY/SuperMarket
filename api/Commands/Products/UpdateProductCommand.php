<?php

class UpdateProductCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($id, $input) {
        if (!isset($input['name']) || !isset($input['product_type_id']) || !isset($input['stock'])) {
            return ["error" => "Nome, tipo e quantidade em estoque são obrigatórios"];
        }

        $sql = $this->pdo->prepare("UPDATE products SET name = ?, product_type_id = ?, stock = ? WHERE id = ?");
        $sql->execute([$input['name'], $input['product_type_id'], $input['stock'], $id]);
        return ["message" => "Produto atualizado com sucesso"];
    }
}