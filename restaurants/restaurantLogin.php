<?php
header("Access-Control-Allow-Origin: *");
include '../connection.php';


if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * from restaurants";
    $result = mysqli_query($connect, $query);


    while ($row = mysqli_fetch_array($result)) {

        if ($row['email'] == $email && password_verify($password, $row['password'])) {
            $user_data = (object) array(
                'user_id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'contact' => $row['contact'],
                'address' => $row['address'],
                'image' => $row['image'],
                'lat' => $row['lat'],
                'lon' => $row['lon'],
            );

            $data = [
                'success' => true,
                'message' => ['Welcome ' . $row['name']],
                'data' => $user_data
            ];

            break;
        } else {

            $data = ['success' => false, 'message' => ['Restaurant not found!']];
        }
    }

    echo json_encode($data);
} else {
    $data = ['success' => false, 'message' => ['Email or Password required!']];
    echo json_encode($data);
}
