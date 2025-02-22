<?php

class MakeSaleCommand {
    private $pdo;
    private $productData = [];

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function GetError($input) {
        if (empty($input['productsSales']) || !is_array($input['productsSales'])) {
            return ["status" => 400, "message" => "Nenhum produto foi selecionado para a venda"];
        }

        if (empty($input['paymentTypeId'])) {
            return ["status" => 400, "message" => "Forma de pagamento inválida"];
        }

        foreach ($input['productsSales'] as $product) {
            if (empty($product['productId']) || empty($product['quantitySold'])) {
                return ["status" => 400, "message" => "Algo deu errado, recarregue a página e tente novamente"];
            }

            if ($product['quantitySold'] < 1) {
                return ["status" => 400, "message" => "Transação negada! Existem itens sendo comprados com quantidades igual a zero!"];
            }
        }

        $placeholders = implode(',', array_fill(0, count($input['productsSales']), '?'));
        $sql = $this->pdo->prepare("
            SELECT p.id, p.cost, pt.product_tax
            FROM products p
            INNER JOIN products_types pt ON p.product_type_id = pt.id
            WHERE p.id IN ($placeholders) AND p.removed = FALSE
        ");
        
        $productIds = array_column($input['productsSales'], 'productId');
        $sql->execute($productIds);

        $this->productData = $sql->fetchAll(PDO::FETCH_ASSOC);

        if ($sql->rowCount() != count($input['productsSales'])) {
            return ["status" => 400, "message" => "Algum dos produtos inseridos está inválido, recarregue a página, por favor"];
        }

        return null;
    }

    public function HasPermission() {
        return true;
    }

    public function Execute($input) {
        try {
            $this->pdo->beginTransaction();

            $saleId = generateRandomId();
            $totalSaleCost = 0;
            $totalTaxes = 0;

            $sqlSale = $this->pdo->prepare("INSERT INTO sales (id, payment_type_id) VALUES (?, ?)");
            $sqlSale->execute([$saleId, $input['paymentTypeId']]);

            $sqlProductSale = $this->pdo->prepare("INSERT INTO products_sales (id, product_id, quantity_sold, total_cost, taxes, sale_id) VALUES (?, ?, ?, ?, ?, ?)");
            $sqlUpdateStock = $this->pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");

            foreach ($input['productsSales'] as $product) {
                $productId = $product['productId'];
                $quantitySold = $product['quantitySold'];

                $productInfo = $this->getProductData($productId);

                if ($productInfo) {
                    $cost = $productInfo['cost'];
                    $productTax = $productInfo['product_tax'];

                    $totalCost = $cost * $quantitySold;
                    $taxes = ($productTax / 100) * $totalCost;

                    $totalSaleCost += $totalCost;
                    $totalTaxes += $taxes;

                    $sqlProductSale->execute([generateRandomId(), $productId, $quantitySold, $totalCost, $taxes, $saleId]);
                    $sqlUpdateStock->execute([$quantitySold, $productId, $quantitySold]);

                    if ($sqlUpdateStock->rowCount() === 0) {
                        $this->pdo->rollBack();
                        return ["status" => 400, "data" => ["error" => "Estoque insuficiente, recarregue a página e tente novamente"]];
                    }
                }
            }
            
            $sqlUpdateSale = $this->pdo->prepare("UPDATE sales SET total_cost = ?, total_taxes = ? WHERE id = ?");
            $sqlUpdateSale->execute([$totalSaleCost, $totalTaxes, $saleId]);

            $this->pdo->commit();

            return ["status" => 201, "data" => ["message" => "Compra efetuada com sucesso!", "saleId" => $saleId]];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ["status" => 500, "data" => ["error" => "Falha ao realizar a compra: " . $e->getMessage()]];
        }        
    }

    private function getProductData($productId) {
        foreach ($this->productData as $product) {
            if ($product['id'] == $productId) {
                return $product;
            }
        }
        return null;
    }
}
