<?php
header("Access-Control-Allow-Origin: *");
include '../connection.php';

$status = $_POST['status'];
$order_id = $_POST['order_id'];

$sql = "UPDATE orders set status='$status' where id='$order_id'";

if (mysqli_query($connect, $sql)) {
    $data = ['success' => true, 'message' => 'Order status updated successfully!'];
} else {
    $data = ['success' => false, 'message' => 'Order status not updated!'];
}

echo json_encode($data);
