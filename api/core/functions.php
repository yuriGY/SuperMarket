<?php
function generateRandomId() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $length = 8;
    $randomId = '';

    for ($i = 0; $i < $length; $i++) {
        $randomId .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomId;
}