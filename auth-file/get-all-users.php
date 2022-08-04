<?php


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:GET');
header('Content-Type:application/json');
include '../database/Database.php';

$obj = new Database();

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    try {
        $data = json_decode(file_get_contents("php://input"));

        $obj->select('users', "*", null, null, 'id DESC', null);        
        $users = $obj->getResult();        
        if ($users) {
            echo json_encode([
                'status' => 1,
                'message' => $users,
            ]);
        } else {
            echo json_encode([
                'status' => 0,
                'message' => "server problem",
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