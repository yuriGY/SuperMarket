<?php

class UpdateProductCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($id, $input) {
        if (empty($id) || strlen($id) !== 8) {
            return ["status" => 400, "message" => "Identificador inválido"];
        }

        $sql = $this->pdo->prepare("SELECT id FROM products WHERE id = ? AND removed = FALSE");
        $sql->execute([$id]);

        if ($sql->rowCount() === 0) {
            return ["status" => 404, "message" => "Produto não encontrado"];
        }

        if (empty($input['name'])) {
            return ["status" => 400, "message" => "O campo Nome é obrigatório"];
        }

        if (empty($input['product_type_id'])) {
            return ["status" => 400, "message" => "O campo Tipo é obrigatório"];
        }

        if (empty($input['stock']) && $input['stock'] != 0) {
            return ["status" => 400, "message" => "O campo Quantidade em estoque é obrigatório"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($id, $input) {
        $sql = $this->pdo->prepare("UPDATE products SET name = ?, product_type_id = ?, stock = ? WHERE id = ?");
        $sql->execute([$input['name'], $input['product_type_id'], $input['stock'], $id]);

        return ["status" => 200, "data" => ["message" => "Produto atualizado com sucesso"]];
    }
}