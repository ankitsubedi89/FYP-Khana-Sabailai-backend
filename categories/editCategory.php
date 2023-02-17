<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';

//add a new category 

$category_id = $_POST['category_id'];
$category_name = $_POST['category_name'];

$sql = "UPDATE categories SET name='$category_name' WHERE id='$category_id'";

$result = mysqli_query($connect, $sql);

if ($result) {
    $response = array(
        'success' => true,
        'message' => 'Category updated successfully'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Something went wrong while updating the category'
    );
}

echo json_encode($response);
