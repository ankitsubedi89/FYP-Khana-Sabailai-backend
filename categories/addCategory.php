<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';

//add a new category 

$category_name = $_POST['category_name'];

$sql = "INSERT INTO categories (name) VALUES ('$category_name')";
$result = mysqli_query($connect, $sql);

if ($result) {
    $response = array(
        'success' => true,
        'message' => 'Category added successfully'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Something went wrong while adding the category'
    );
}

echo json_encode($response);
