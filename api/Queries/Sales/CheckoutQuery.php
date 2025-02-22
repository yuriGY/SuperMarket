<?php

class CheckoutQuery {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($id) {
        if (empty($id) || strlen($id) !== 8) {
            return ["status" => 400, "message" => "Identificador inválido"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($id) {
        $sql = $this->pdo->prepare("
            SELECT p.name, p.cost, pt.product_tax, ps.quantity_sold, ps.total_cost, ps.taxes, s.total_cost AS total_sale_cost, s.total_taxes
            FROM sales s
            INNER JOIN products_sales ps ON (ps.sale_id=s.id)
            INNER JOIN products p ON (p.id=ps.product_id)
            INNER JOIN products_types pt ON (pt.id=p.product_type_id)
            WHERE ps.sale_id = ?
        ");
        $sql->execute([$id]);
        $sale = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (!$sale) {
            return ["status" => 404, "data" => ["error" => "Carrinho não encontrado, recarregue a página e tente novamente"]];
        }

        return ["status" => 200, "data" => $sale];
    }
}