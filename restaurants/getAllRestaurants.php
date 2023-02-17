<?php

header("Access-Control-Allow-Origin: *");

include '../connection.php';

$query = "SELECT * from restaurants";
$result = mysqli_query($connect, $query);

$restaurant_array = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($restaurant_array, $row);
}

$response = [
    'success' => true,
    'message' => 'Restaurant fetched successfully',
    'data' => $restaurant_array
];

echo json_encode($response);
