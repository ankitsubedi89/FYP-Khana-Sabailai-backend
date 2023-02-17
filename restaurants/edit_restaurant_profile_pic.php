<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';
include '../uploadImage.php';

$restaurantId = isset($_POST['userId']) ? $_POST['userId'] : "";
$user_data = array();

if (isset($_POST['userId']) && isset($_FILES['image'])) {
    $restaurantId = $_POST['userId'];

    $img_loc = null;

    if (isset($_FILES['image'])) {
        $image = uploadImage($_FILES['image']);
        if ($image['success']) {
            $img_loc = $image['data'];
        } else {
            $data = ['success' => false, 'message' => $image['message']];
            echo json_encode($data);
            exit();
        }
    }

    $updateDetails = "UPDATE restaurants set image = '$img_loc' where id = '$restaurantId'";

    if (mysqli_query($connect, $updateDetails)) {
        $data = ['success' => true, 'message' => ['Successfully updated!'], 'data' => $img_loc];
        echo json_encode($data);
    } else {
        $data = ['success' => false, 'message' => ['Something went wrong!']];
        echo json_encode($data);
    }
} else {
    $data = ['success' => false, 'message' => ['RestaurantId required']];
    echo json_encode($data);
}
