<?php
function sendResponse($status, $data, $headers = []) {
    http_response_code($status);
    header('Content-Type: application/json');
    foreach ($headers as $header) {
        header($header);
    }
    echo json_encode($data);
    exit;
}