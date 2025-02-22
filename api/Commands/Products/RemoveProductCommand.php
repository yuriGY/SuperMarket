<?php

class RemoveProductCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($id) {
        $sql = $this->pdo->prepare("UPDATE products SET removed = TRUE WHERE id = ?");
        $sql->execute([$id]);
        return ["message" => "Produto removido com sucesso"];
    }
}