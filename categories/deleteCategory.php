<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';


$category_id = $_POST['category_id'];

$sql = "DELETE from categories where id = $category_id";

$result = mysqli_query($connect, $sql);

if ($result) {
    $response = array(
        'success' => true,
        'message' => 'Category deleted successfully'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Something went wrong while deleting the category'
    );
}

echo json_encode($response);
