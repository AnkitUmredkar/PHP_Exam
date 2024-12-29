<?php

class Config
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "exam_database";
    private $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }

    public function insertData($name, $email, $phone)
    {
        $query = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', $phone)";
        $res = mysqli_query($this->connection, $query);
        return $res;
    }

    public function insertDataInProducts($productName, $price)
    {
        $query = "INSERT INTO products (productName, price) VALUES ('$productName', '$price')";
        $res = mysqli_query($this->connection, $query);
        return $res;
    }

    public function insertDataInOrders($orderDate, $status)
    {
        $query = "INSERT INTO orders (orderDate, status) VALUES ('$orderDate', '$status')";
        $res = mysqli_query($this->connection, $query);
        return $res;
    }

    public function readData($tableName)
    {
        $query = "SELECT * FROM $tableName";
        $res = mysqli_query($this->connection, $query);
        return $res;
    }

    public function updatedata($id, $productName, $price)
    {
        $query = "UPDATE products SET productName = '$productName', price = '$price' WHERE id = $id";
        $res = mysqli_query($this->connection, $query);
        return $res;
    }

    public function deleteData($id)
    {
        $query = "DELETE FROM orders WHERE id = $id";
        $res = mysqli_query($this->connection, $query);
        return $res;
    }
}
