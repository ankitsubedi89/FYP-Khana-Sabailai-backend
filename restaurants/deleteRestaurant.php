<?php


header("Access-Control-Allow-Origin: *");
include '../connection.php';

$id = $_POST['id'];
$status = $_POST['status'];
$query = "UPDATE restaurants SET is_deleted = $status WHERE id = $id";
$result = mysqli_query($connect, $query);

$status == 1 ? $stat = 'hidden' : $stat = 'restored';

if ($result) {
    $response = array(
        'success' => true,
        'message' => "Restaurant $stat successfully"
    );
} else {
    $response = array(
        'success' => false,
        'message' => "Something went wrong "
    );
}

echo json_encode($response);
