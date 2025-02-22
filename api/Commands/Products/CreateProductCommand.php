<?php

class CreateProductCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($input) {
        if (!isset($input['name']) || !isset($input['product_type_id']) || !isset($input['stock'])) {
            return ["error" => "Nome, tipo e quantidade em estoque são obrigatórios"];
        }

        $sql = $this->pdo->prepare("INSERT INTO products (id, name, product_type_id, stock) VALUES (?, ?, ?, ?)");
        $sql->execute([generateRandomId(), $input['name'], $input['product_type_id'], $input['stock']]);
        return ["message" => "Produto criado com sucesso"];
    }
}