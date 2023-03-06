<?php

header("Access-Control-Allow-Origin: *");
include '../connection.php';

if (isset($_POST['user_id'])) {
    $restaurant_id = $_POST['user_id'];
    $sql = "SELECT o.*, r.name as restaurant_name, r.contact as restaurant_contact, r.address as restaurant_address, u.name as user_name, u.address as user_address, u.contact as user_contact from orders o join restaurants r on r.id = o.restaurant_id join users u on o.user_id = u.id where o.restaurant_id='$restaurant_id' order by o.date desc";
    $result = mysqli_query($connect, $sql);

    $order_arr = array();

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $ord_id = $row['id'];

            $order_lines_sql = "SELECT o.id as order_detail_id, o.menu_id, m.food, m.price, m.image, m.description, c.id as cat_id, c.name as cat_name, o.quantity, o.line_total from order_details o join menu m on o.menu_id = m.id join categories c on m.category_id = c.id where o.order_id = '$ord_id'";
            $order_lines_result = mysqli_query($connect, $order_lines_sql);

            $order_lines_array = array();

            while ($order_lines_row = mysqli_fetch_array($order_lines_result)) {

                $order_lines_array[] = array(
                    'order_detail_id' => $order_lines_row['order_detail_id'],
                    'menu_id' => $order_lines_row['menu_id'],
                    'food' => $order_lines_row['food'],
                    'price' => $order_lines_row['price'],
                    'image' => $order_lines_row['image'],
                    'description' => $order_lines_row['description'],
                    'cat_id' => $order_lines_row['cat_id'],
                    'cat_name' => $order_lines_row['cat_name'],
                    'quantity' => $order_lines_row['quantity'],
                    'line_total' => $order_lines_row['line_total']
                );
            }
            $data = $row;
            $data['order_lines'] = $order_lines_array;

            $order_arr[] = $data;
        }
        $data = ['success' => true, 'message' => 'Orders fetched successfully!', 'data' => $order_arr];
    } else {
        $data = ['success' => false, 'message' => 'No orders found!', 'data' => []];
    }
    echo json_encode($data);
} else {
    $data = ['success' => false, 'message' => 'User id is required!'];
    echo json_encode($data);
}
