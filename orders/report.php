<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';

$sql = "";

$isTime = isset($_POST['time']);
$restaurantId = isset($_POST['restaurantId']);
if ($isTime) {
    $time = $_POST['time'];
    if ($time == 'last_7_days') {
        $sql = "WHERE ord.date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
    } else if ($time == 'last_30_days') {
        $sql = "WHERE ord.date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()";
    } else if ($time == 'last_90_days') {
        $sql = "WHERE ord.date BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()";
    } else if ($time == 'last_180_days') {
        $sql = "WHERE ord.date BETWEEN DATE_SUB(NOW(), INTERVAL 180 DAY) AND NOW()";
    } else if ($time == 'last_365_days') {
        $sql = "WHERE ord.date BETWEEN DATE_SUB(NOW(), INTERVAL 365 DAY) AND NOW()";
    } else {
        $sql = "";
    }
}

if ($restaurantId) {
    $restaurantId = $_POST['restaurantId'];
    if ($sql != "")
        $sql .= " AND ord.restaurant_id = '$restaurantId'";
    else
        $sql = "WHERE ord.restaurant_id = '$restaurantId'";
}

$report_array = array();

//get total orders from orders table and add to report_array

$report_total_sql = "SELECT COUNT(*) as total_orders FROM orders ord";
if ($isTime) {
    $report_total_sql .= " $sql";
}
$report_total_result = mysqli_query($connect, $report_total_sql);
$total_orders = 0;
while ($report_total_row = mysqli_fetch_array($report_total_result)) {
    $report_total_orders = $report_total_row['total_orders'];
    $total_orders = $report_total_orders;
}
$report_array['total_orders'] = $total_orders;

//get sum of tatal_cost from orders table and add to report_array

$report_sql = "SELECT SUM(total_cost) as total_sales FROM orders ord";
if ($isTime) {
    $report_sql .= " $sql";
}
$report_result = mysqli_query($connect, $report_sql);

$total_sales = 0;

while ($report_row = mysqli_fetch_array($report_result)) {
    $report_total_sales = $report_row['total_sales'];
    $total_sales = $report_total_sales;
}

$report_array['total_sales'] = $total_sales;

//get sum of total sales of each food in menu table and add to report_array

$report_menu_sql = "SELECT m.food, m.image, SUM(o.quantity) as total_quantity, SUM(o.line_total) as total_sales, ord.date FROM order_details o JOIN menu m ON o.menu_id = m.id join orders ord on ord.id = o.order_id GROUP BY m.food ORDER BY total_sales DESC limit 5";
if ($isTime) {
    $report_menu_sql = "SELECT m.food, m.image, SUM(o.quantity) as total_quantity, SUM(o.line_total) as total_sales, ord.date FROM order_details o JOIN menu m ON o.menu_id = m.id join orders ord on ord.id = o.order_id $sql GROUP BY m.food ORDER BY total_sales DESC limit 5";
}

$report_menu_result = mysqli_query($connect, $report_menu_sql);

while ($report_menu_row = mysqli_fetch_array($report_menu_result)) {
    $report_menu_food = $report_menu_row['food'];
    $report_menu_image = $report_menu_row['image'];
    $report_menu_total_quantity = $report_menu_row['total_quantity'];
    $report_menu_total_sales = $report_menu_row['total_sales'];
    $report_menu_date = $report_menu_row['date'];
    $arr[] = array(
        'food' => $report_menu_food,
        'image' => $report_menu_image,
        'total_quantity' => $report_menu_total_quantity,
        'total_sales' => $report_menu_total_sales,
        'date' => $report_menu_date
    );
}

$report_array['menu'] = $arr;
$report_array['success'] = true;


echo json_encode($report_array);
