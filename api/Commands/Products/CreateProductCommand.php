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

    public function Execute($input) {
        $sql = $this->pdo->prepare("INSERT INTO products (id, name, product_type_id, stock) VALUES (?, ?, ?, ?)");
        $sql->execute([generateRandomId(), $input['name'], $input['product_type_id'], $input['stock']]);

        return ["status" => 201, "data" => ["message" => "Produto criado com sucesso"]];
    }
}