<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:POST');
header('Content-Type:application/json');
include '../database/Database.php';
include '../vendor/autoload.php';

use \Firebase\JWT\JWT;

$obj = new Database();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"));
        $allheaders = getallheaders();
        $jwt = $allheaders['Authorization'];
        $secret_key = "HighQ Innovations";
        $user_data = JWT::decode($jwt, $secret_key, array('HS256'));

        $id = $user_data->data->id;
        // $title = $data->title;
        // $content = $data->content;
        // $price = $data->price;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $price = $_POST['price'];

        if (!empty($title) && !empty($content) && !empty($price)) {
            $obj->insert('products', ['title' => $title, 'user_id' => $id, 'content' => $content, 'price' => $price]);
            $result = $obj->getResult();
            if ($result[0] == 1) {
                echo json_encode([
                    'status' => 1,
                    'message' => "Product Add Successfully",
                ]);
            } else {
                echo json_encode([
                    'status' => 0,
                    'message' => "Server Problem",
                ]);
            }
        }else {  
            http_response_code(407);          
            echo json_encode([
                'status' => 0,
                'message' => "All fields are required",
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 0,
            'message' => $e->getMessage(),
        ]);
    }
} else {
    echo json_encode([
        'status' => 0,
        'message' => 'Access Denied',
    ]);
}
