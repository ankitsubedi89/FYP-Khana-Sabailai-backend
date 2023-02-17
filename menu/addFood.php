<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';



if (isset($_POST['image']) && isset($_POST['quantity']) && isset($_POST['restaurant_id']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['category'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $restaurant_id = $_POST['restaurant_id'];


    $base64_string = $_POST["image"];

    $imagebase64  = base64_decode($base64_string);
    $img_loc         = 'upload/' . uniqid() . '.png';
    $file         = '../' . $img_loc;
    file_put_contents($file, $imagebase64);
    $sql = "INSERT INTO menu (food, price, description, category_id, image, restaurant_id, quantity) VALUES ('$name', '$price', '$description', '$category', '$img_loc','$restaurant_id','$quantity')";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        $response = ['success' => true, 'message' => 'Food added successfully'];
    } else {
        $response = ['success' => false, 'message' => 'Something went wrong while adding the food'];
    }
} else {
    $response = ['success' => false, 'message' => 'No Images Selected!'];
}

echo json_encode($response);
