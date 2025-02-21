<?php
function getDbConnection() {
    $host = 'localhost';
    $port = '5432';
    $dbname = 'super_market';
    $user = 'postgres';
    $password = 'senha';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco: " . $e->getMessage());
    }
}
