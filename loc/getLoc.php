<?php
header("Access-Control-Allow-Origin: *");

include '../connection.php';

//get all loc
$query = "SELECT * FROM loc";
if ($result = mysqli_query($connect, $query)) {
    $data = ['success' => true, 'message' => ['LOC fetched successfully!'], 'data' => []];
    while ($row = mysqli_fetch_assoc($result)) {
        $data['data'][] = $row;
    }
} else {
    $data = ['success' => false, 'message' => ['Something went wrong!']];
}
echo  json_encode($data);