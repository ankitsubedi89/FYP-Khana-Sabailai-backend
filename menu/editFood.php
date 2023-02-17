<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';


if (isset($_POST['name']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['id'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $id = $_POST['id'];

    if (isset($_POST['image'])) {
        $base64_string = $_POST["image"];

        $imagebase64  = base64_decode($base64_string);
        $img_loc         = 'upload/' . uniqid() . '.png';
        $file         = '../' . $img_loc;
        file_put_contents($file, $imagebase64);

        $sql = "UPDATE menu SET quantity = '$quantity', food = '$name', price = '$price', description = '$description', image = '$img_loc' WHERE id = $id";
    } else {

        $description = $_POST['description'];
        $sql = "UPDATE menu SET quantity = '$quantity', food = '$name', price = '$price', description = '$description' WHERE id = $id";
    }
    $result = mysqli_query($connect, $sql);

    if ($result) {

        $menu_sql = "SELECT * FROM menu WHERE id = $id";
        $menu_result = mysqli_query($connect, $menu_sql);
        $menu_row = mysqli_fetch_assoc($menu_result);
        $menu_image = $menu_row['image'];

        $menu_array[] = array(
            'id' => $id,
            'food' => $name,
            'price' => $price,
            'image' => $menu_image,
            'description' => $description,
        );
        $response = ['success' => true, 'message' => 'Dish edited successfully', 'menu' => $menu_array];
    } else {
        $response = ['success' => false, 'message' => 'Something went wrong while editing the dish'];
    }
} else {
    $response = ['success' => false, 'message' => 'Fields are required!'];
}

echo json_encode($response);
