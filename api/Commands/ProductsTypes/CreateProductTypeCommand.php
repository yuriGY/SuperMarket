<?php

class CreateProductTypeCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($input) {
        if (!isset($input['name']) || !isset($input['product_tax'])) {
            return ["error" => "Nome e imposto pago são obrigatórios"];
        }

        $stmt = $this->pdo->prepare("INSERT INTO products_types (id, name, product_tax) VALUES (?, ?, ?)");
        $stmt->execute([generateRandomId(), $input['name'], $input['product_tax']]);
        return ["message" => "Tipo de produto criado com sucesso"];
    }
}