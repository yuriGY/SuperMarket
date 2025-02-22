<?php

class RequestHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handle($command, $params = []) {
        $error = $command->GetError(...$params);
        if ($error) {
            return ["status" => $error['status'], "data" => ["error" => $error['message']]];
        }

        if (!$command->HasPermission()) {
            return ["status" => 403, "data" => ["error" => "Permissão negada"]];
        }

        return $command->Execute(...$params);
    }
}
