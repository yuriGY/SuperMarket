<?php

class CreateProductTypeCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($input) {
        if (empty($input['name'])) {
            return ["status" => 400, "message" => "O campo Nome é obrigatório"];
        }

        if (empty($input['product_tax']) && $input['product_tax'] != 0) {
            return ["status" => 400, "message" => "O campo Imposto pago é obrigatório"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($input) {
        $sql = $this->pdo->prepare("INSERT INTO products_types (id, name, product_tax) VALUES (?, ?, ?)");
        $sql->execute([generateRandomId(), $input['name'], $input['product_tax']]);

        return ["status" => 201, "data" => ["message" => "Tipo de produto criado com sucesso"]];
    }
}