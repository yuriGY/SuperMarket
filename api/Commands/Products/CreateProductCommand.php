<?php

class CreateProductCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($input) {
        if (empty($input['name'])) {
            return ["status" => 400, "message" => "O campo Nome é obrigatório"];
        }

        if (empty($input['productTypeId']) || strlen($input['productTypeId']) !== 8) {
            return ["status" => 400, "message" => "O campo Tipo é obrigatório"];
        }

        if (empty($input['stock']) && $input['stock'] != 0) {
            return ["status" => 400, "message" => "O campo Quantidade em estoque é obrigatório"];
        }

        if (empty($input['cost']) && $input['cost'] >= 0) {
            return ["status" => 400, "message" => "O campo Custo é obrigatório e não pode ser negativo"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($input) {
        $sql = $this->pdo->prepare("INSERT INTO products (id, name, product_type_id, stock, cost) VALUES (?, ?, ?, ?, ?)");
        $sql->execute([generateRandomId(), $input['name'], $input['productTypeId'], $input['stock'], $input['cost']]);

        return ["status" => 201, "data" => ["message" => "Produto criado com sucesso"]];
    }
}