<?php

//чтобы получить доступ из нашей странички
header('Access-Control-Allow-Origin: *');

require_once('/var/www/classes/autoload.php');

$result = User::logIn();

if ($result !== null) {
    $response = [
        'success' => true,
        'token' => $result
    ];
} else {
    $response = [
        'success' => false,
        'error' => 'неверный логин или пароль'
    ];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);