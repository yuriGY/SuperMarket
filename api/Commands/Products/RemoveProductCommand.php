<?php

class RemoveProductCommand {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($id) {
        if (empty($id) || strlen($id) !== 8) {
            return ["status" => 400, "message" => "Identificador inválido"];
        }

        $sql = $this->pdo->prepare("SELECT id FROM products WHERE id = ? AND removed = FALSE");
        $sql->execute([$id]);

        if ($sql->rowCount() === 0) {
            return ["status" => 404, "message" => "Produto não encontrado"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($id) {
        $sql = $this->pdo->prepare("UPDATE products SET removed = TRUE WHERE id = ?");
        $sql->execute([$id]);
        return ["status" => 200, "data" => ["message" => "Produto removido com sucesso"]];
    }
}