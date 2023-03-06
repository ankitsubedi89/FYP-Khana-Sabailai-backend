
<?php
header("Access-Control-Allow-Origin: *");

include '../connection.php';

$date = date('Y-m-d H:i:s');

if (isset($_POST['restaurant_id'])) {
    $resId = $_POST['restaurant_id'];
    $query = "SELECT * FROM menu where is_deleted = 0 and restaurant_id = $resId";
} else {
    // adding date condition to fetch only todays menu
    $query = "SELECT * FROM menu where is_deleted = 0 and DATEDIFF(date, current_timestamp()) = 0";
}

if ($result = mysqli_query($connect, $query)) {
    $data = ['success' => true, 'message' => ['Menu fetched successfully!'], 'data' => []];
    while ($row = mysqli_fetch_assoc($result)) {
        $data['data'][] = $row;
    }
} else {
    $data = ['success' => false, 'message' => ['Something went wrong!']];
}
echo  json_encode($data);
