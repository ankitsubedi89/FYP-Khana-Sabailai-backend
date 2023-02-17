<?php
header("Access-Control-Allow-Origin: *");

include '../connection.php';


if (
    isset($_POST['name']) &&
    isset($_POST['email']) &&
    isset($_POST['contact']) &&
    isset($_POST['address']) &&
    isset($_POST['password'])
) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    //check if the email already exists
    $query = "SELECT * from users where email = '$email'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        $data = ['success' => false, 'message' => ['Email already exists!']];
        echo json_encode($data);
        exit();
    }


    $query = "INSERT INTO users ( name, email,password,contact,address) VALUES ('$name', '$email', '$password', '$contact','$address')";
    if ($result = mysqli_query($connect, $query)) {
        $data = ['success' => true, 'message' => ['User Sucessfully signed up!']];
    } else {
        $data = ['success' => false, 'message' => ['Something went wrong!']];
    }
    echo  json_encode($data);
} else {
    $data = ['success' => false, 'message' => ['All the fields are required!']];
    echo json_encode($data);
}
