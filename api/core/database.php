<?php
require_once 'config.php';

function getDbConnection() {
    $config = include 'config.php';
    $dbConfig = $config['database'];

    $dsn = "pgsql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};";

    try {
        $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
        sendResponse(500, ["error" => "Erro interno ao conectar ao banco de dados"]);
        exit;
    }
}