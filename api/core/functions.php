<?php
function generateRandomId() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 8;
    $randomId = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomId .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $randomId;
}
