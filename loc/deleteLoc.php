<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';


$loc_id = $_POST['id'];

$sql = "DELETE from loc where id = $loc_id";

$result = mysqli_query($connect, $sql);

if ($result) {
    $response = array(
        'success' => true,
        'message' => 'Letover Company deleted successfully'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Something went wrong while deleting the leftover company'
    );
}

echo json_encode($response);
