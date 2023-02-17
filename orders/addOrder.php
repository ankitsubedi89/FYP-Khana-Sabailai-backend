<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';

$restaurant_id = $_POST['restaurant_id'];
$user_id = $_POST['user_id'];
$total_price = $_POST['total_price'];
$special_request = $_POST['special_request'];
$orders = json_decode($_POST['orders']);
$date = date('Y-m-d H:i:s');



// Get max order id from orders table
$maxQuery = "SELECT max(id) from orders";
$maxResult = mysqli_query($connect, $maxQuery);
$maxRow = mysqli_fetch_array($maxResult);
$maxId = $maxRow[0];
$order_id = $maxId + 1;

$main_sql = "INSERT INTO orders (id, restaurant_id, user_id, total_cost, special_request, date) VALUES ('$order_id', '$restaurant_id','$user_id', '$total_price', '$special_request', '$date')";


if (mysqli_query($connect, $main_sql)) {
    foreach ($orders as $order) {
        $menu_id = $order->id;
        $quantity = $order->quantity;
        $line_total = $order->line_total;

        $sub_sql = "INSERT INTO `order_details`(`order_id`, `menu_id`, `quantity`, `line_total`) VALUES ('$order_id','$menu_id','$quantity','$line_total')";

        if (mysqli_query($connect, $sub_sql)) {
            $data = ['success' => true, 'message' => 'Order added successfully!'];
        } else {
            $data = ['success' => false, 'message' => 'Order not added!'];
        }
    }
} else {
    $data = ['success' => false, 'message' => 'Order not added!'];
}

echo json_encode($data);
