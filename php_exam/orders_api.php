<?php

// header("Access-Control-Allow-Method: POST, GET, DELETE");
header("Content-Type: application/json");
include "config\config.php";

$c1 = new Config();

$arr = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $orderDate = $_POST["orderDate"];
        $status = $_POST["status"];

        if ($orderDate != null && $orderDate != '') {
            if ($status != null && $status != '') {
                $res = $c1->insertDataInOrders($orderDate, $status);
                if ($res) {
                    $arr['response'] = "Insertion Completed!";
                } else {
                    $arr['response'] = "Failed to insert data!";
                }
            } else {
                http_response_code(400);
                $arr['error'] = "Status not passed!";
            }
        } else {
            http_response_code(400);
            $arr['error'] = "Order is not passed";
        }

        break;

    case 'GET':
        $res = $c1->readData("orders");
        $orders = [];

        if ($res) {
            while ($data = mysqli_fetch_assoc($res)) {
                array_push($orders, $data);
            }
            $arr['data'] = $orders;
        } else {
            $arr['error'] = "Data not found!";
        }
        break;

    case 'DELETE':
        $data = file_get_contents("php://input");
        parse_str($data, $result);

        $id = $result['id'];
        $res = $c1->deleteData($id);

        if ($res) {
            $arr["response"] = "Data deleted successfully!";
        } else {
            $arr["response"] = "Failed to update data!";
        }

        break;

    default:
        http_response_code(400);
        $arr['error'] = "Invalid request type!. Only GET, POST and DELETE requests are allowed";
        break;
}

echo json_encode($arr);
