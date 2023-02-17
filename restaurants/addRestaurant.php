<?php
header("Access-Control-Allow-Origin: *");

include '../connection.php';
include '../uploadImage.php';


if (
    isset($_POST['name']) &&
    isset($_POST['email']) &&
    isset($_POST['contact']) &&
    isset($_POST['address']) &&
    isset($_POST['password']) &&
    isset($_POST['lat']) &&
    isset($_POST['lon'])
) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $image = null;

    if (isset($_FILES['image'])) {
        $image = uploadImage($_FILES['image']);
        if ($image['success']) {
            $image = $image['data'];
        } else {
            $data = ['success' => false, 'message' => $image['message']];
            echo json_encode($data);
            exit();
        }
    }


    $query = "INSERT INTO restaurants ( name, email,password,contact,address, lat, lon,image) VALUES ('$name', '$email', '$password', '$contact','$address','$lat','$lon','$image')";
    if ($result = mysqli_query($connect, $query)) {
        $data = ['success' => true, 'message' => ['Restaurant Sucessfully added!']];
    } else {
        $data = ['success' => false, 'message' => ['Something went wrong!']];
    }
    echo  json_encode($data);
} else {
    $data = ['success' => false, 'message' => ['All the fields are required!']];
    echo json_encode($data);
}
