<?php

//    add headers

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:GET');
header('Content-Type:application/json');

if($_SERVER["REQUEST_METHOD"] == "GET"){
    echo json_encode([
        'status' => 1,
        'message' => 'Welcome to API with PHP with JWT Authentication',
    ]);
}else {
    echo json_encode([
        'status' => 0,
        'message' => 'Access Denied',
    ]);
}
