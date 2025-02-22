<?php

class RemoveProductTypeCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($id) {
        $sql = $this->pdo->prepare("UPDATE products_types SET removed = TRUE WHERE id = ?");
        $sql->execute([$id]);
        return ["message" => "Tipo de produto removido com sucesso"];
    }
}