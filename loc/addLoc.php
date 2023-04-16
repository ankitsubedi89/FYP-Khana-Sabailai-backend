<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';

//add a new category 

$loc_name = $_POST['name'];
$loc_email = $_POST['email'];
$loc_contact = $_POST['contact'];

$sql = "INSERT INTO loc (name, email, contact) VALUES ('$loc_name', '$loc_email', '$loc_contact')";
$result = mysqli_query($connect, $sql);

if ($result) {
    $response = array(
        'success' => true,
        'message' => 'Leftover Company added successfully'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Something went wrong while adding the leftover company'
    );
}

echo json_encode($response);
