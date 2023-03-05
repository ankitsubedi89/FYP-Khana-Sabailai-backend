<?php
header("Access-Control-Allow-Origin: *");
include '../connection.php';

$status = $_POST['status'];
$order_id = $_POST['order_id'];

$sql = "UPDATE orders set status='$status' where id='$order_id'";

//to change the quantity of the menu after order is confirmed
if ($status == '1' || $status == '2') {
    $order_detail_sql = "SELECT menu_id, quantity from order_details where order_id = '$order_id'";
    $order_detail_response = mysqli_query($connect, $order_detail_sql);
    while ($order_detail_row = mysqli_fetch_array($order_detail_response)) {
        $order_quantity = $order_detail_row['quantity'];
        $order_menu_id = $order_detail_row['menu_id'];
        $menu_sql = "Update menu set quantity = (quantity - $order_quantity) where id = $order_menu_id";
        mysqli_query($connect, $menu_sql);
    }
}

if (mysqli_query($connect, $sql)) {
    $data = ['success' => true, 'message' => 'Order status updated successfully!'];
} else {
    $data = ['success' => false, 'message' => 'Order status not updated!'];
}

echo json_encode($data);
