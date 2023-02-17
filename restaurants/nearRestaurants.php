<?php

header("Access-Control-Allow-Origin: *");

include '../connection.php';

$lat = $_POST['lat'];
$lon = $_POST['lon'];

// 5
$dis = $_POST['distance'];

$query = "SELECT * from restaurants";
$result = mysqli_query($connect, $query);

$restaurant_array = array();



function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    } else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}


//10

while ($row = mysqli_fetch_assoc($result)) {
    // row = 4
    $distance = distance($lat, $lon, $row['lat'], $row['lon'], "K");
    // dis -5

    // dis  1
    if ($distance <= $dis) {
        array_push($restaurant_array, $row);
    }
}

$response = [
    'success' => true,
    'message' => 'Restaurant fetched successfully',
    'data' => $restaurant_array
];

echo json_encode($response);
