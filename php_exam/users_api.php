<?php

header("Content-Type: application/json");
include "config\config.php";

$c1 = new Config();

$arr = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        if ($name != '' && $name != null) {
            if ($email != '' && $email != null) {
                if ($phone != '' && $phone != null) {
                    $res = $c1->insertData($name, $email, $phone);
                    if ($res) {
                        $arr["response"] = "Data Inserted Successfully!";
                    } else {
                        $arr["response"] = "Failed to insert data!";
                    }
                } else {
                    http_response_code(400);
                    $arr['error'] = "Phone number not passed!";
                    break;
                }
            } else {
                http_response_code(400);
                $arr['error'] = "Email address not passed!";
                break;
            }
        } else {
            http_response_code(400);
            $arr['error'] = "Name not passed!";
            break;
        }

        break;

    case 'GET':
        $res = $c1->readData("users");
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

    default:
        http_response_code(400);
        $arr['error'] = "Invalid request type!. Only GET and POST requests are allowed";
        break;
}

echo json_encode($arr);
