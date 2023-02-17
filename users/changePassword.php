<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';
include '../uploadImage.php';


if (
    isset($_POST['id']) &&
    isset($_POST['old_password']) &&
    isset($_POST['new_password'])
) {
    $user_id = $_POST['id'];
    $password = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    $sql = "SELECT * from users where id='$user_id'";
    $result = mysqli_query($connect, $sql);

    if ($result->num_rows > 0) {
        while ($row[] = $result->fetch_assoc()) {
            $tem = $row;
        }
        $dbPWD = $tem[0]['password'];
        if (password_verify($password, $dbPWD)) {
            $newPw = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateDetails = "UPDATE users set password='$newPw' where id='$user_id'";
            if ($result = mysqli_query($connect, $updateDetails)) {
                $data = ['success' => true, 'message' => ['Password Sucessfully updated!']];
            } else {
                $data = ['success' => false, 'message' => ['Something went wrong!']];
            }
            echo json_encode($data);
        } else {

            $data = ['success' => false, 'message' => ['Old Password is incorrect!']];
            echo json_encode($data);
        }
    } else {
        $data = ['success' => false, 'message' => ['User not found!']];
        echo json_encode($data);
    }
} else {
    $data = ['success' => false, 'message' => ['All the fields are required!']];
    echo json_encode($data);
}
