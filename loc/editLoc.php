<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';

//add a new category 

$loc_id = $_POST['id'];
$loc_name = $_POST['name'];
$loc_email = $_POST['email'];
$loc_contact = $_POST['contact'];

$sql = "UPDATE loc SET name='$loc_name', contact='$loc_contact', email='$loc_email' WHERE id='$loc_id'";
$result = mysqli_query($connect, $sql);

if ($result) {
    $response = array(
        'success' => true,
        'message' => 'Leftover Company edited successfully'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Something went wrong while editing the leftover company'
    );
}

echo json_encode($response);
