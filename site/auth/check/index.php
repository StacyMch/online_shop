<?php
//чтобы получить доступ из нашей странички
header('Access-Control-Allow-Origin: *');

require_once('/var/www/classes/autoload.php');

if (User::check()) {
    $response = [
        'success' => true
    ];
} else {
    $response = [
        'success' => false,
        'error' => 'юзер не авторизован'
    ];
}

print(json_encode($response, JSON_UNESCAPED_UNICODE));

