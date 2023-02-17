<?php
header("Access-Control-Allow-Origin: *");
include '../connection.php';

if (isset($_POST['name']) && isset($_POST['contact']) && isset($_POST['lat']) && isset($_POST['lon']) && isset($_POST['address']) && isset($_POST['user_id'])) {

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $user_id = $_POST['user_id'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];

    $query = "UPDATE restaurants SET name = '$name', contact = '$contact', address = '$address', lat = '$lat', lon = '$lon' WHERE id = '$user_id'";
    if ($result = mysqli_query($connect, $query)) {
        $data = ['success' => true, 'message' => ['Restaurant Sucessfully updated!']];
    } else {
        $data = ['success' => false, 'message' => ['Something went wrong!']];
    }
    echo json_encode($data);
} else {
    $data = ['success' => false, 'message' => ['All fields are required!']];
    echo json_encode($data);
}
