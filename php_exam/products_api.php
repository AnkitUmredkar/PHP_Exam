<?php

header("Content-Type: application/json");
include "config\config.php";

$c1 = new Config();

$arr = [];

switch ($_SERVER["REQUEST_METHOD"]) {

    case 'POST':
        $productName = $_POST['productName'];
        $price = $_POST['price'];

        if ($productName != '' && $productName != null) {
            if ($price != '' && $price != null) {
                $res = $c1->insertDataInProducts($productName, $price);
                if ($res) {
                    $arr["response"] = "Data Inserted Successfully!";
                } else {
                    $arr["response"] = "Failed to insert data!";
                }
            } else {
                http_response_code(400);
                $arr['error'] = "Price not passed!";
            }
        } else {
            http_response_code(400);
            $arr['error'] = "Product Name not passed!";
        }

        break;

    case 'GET':
        $res = $c1->readData("products");
        $users = [];

        if ($res) {
            while ($data = mysqli_fetch_assoc($res)) {
                array_push($users, $data);
            }
            $arr['data'] = $users;
        } else {
            http_response_code(400);
            $arr['error'] = "Data not found!";
        }
        break;

    case 'PUT':
        $data = file_get_contents("php://input");
        parse_str($data, $result);

        $id = $result['id'];
        $productName = $result['productName'];
        $price = $result['price'];

        if ($id != null && $id != '') {
            if ($productName != null && $productName != '') {
                if ($price != null && $price != '') {
                    $res = $c1->updateData($id, $productName, $price);
                    if ($res) {
                        $arr["response"] = "Data updated successfully!";
                    } else {
                        $arr["response"] = "Failed to update data!";
                    }
                } else {
                    http_response_code(400);
                    $arr['error'] = "Price not passed!";
                }
            } else {
                http_response_code(400);
                $arr['error'] = "Product name not passed!";
            }
        } else {
            http_response_code(400);
            $arr['error'] = "Id not passed!";
        }

        break;

    default:
        http_response_code(400);
        $arr['error'] = "Invalid request type!. Only GET, POST and PUT requests are allowed";
        break;
}


echo json_encode($arr);