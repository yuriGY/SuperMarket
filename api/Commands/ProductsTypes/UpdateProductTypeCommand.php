<?php

class UpdateProductTypeCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($id, $input) {
        if (empty($id) || strlen($id) !== 8) {
            return ["status" => 400, "message" => "Identificador inválido"];
        }

        $sql = $this->pdo->prepare("SELECT id FROM products_types WHERE id = ? AND removed = FALSE");
        $sql->execute([$id]);

        if ($sql->rowCount() === 0) {
            return ["status" => 404, "message" => "Tipo de produto não encontrado"];
        }

        if (empty($input['name'])) {
            return ["status" => 400, "message" => "O campo Nome é obrigatório"];
        }

        if (empty($input['productTax']) && $input['productTax'] != 0) {
            return ["status" => 400, "message" => "O campo Imposto pago é obrigatório"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($id, $input) {
        $sql = $this->pdo->prepare("UPDATE products_types SET name = ?, product_tax = ? WHERE id = ?");
        $sql->execute([$input['name'], $input['productTax'], $id]);

        return ["status" => 200, "data" => ["message" => "Tipo de produto atualizado com sucesso"]];
    }
}