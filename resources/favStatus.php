<?php
include "./db_connection.php";
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');
$method = $_SERVER['REQUEST_METHOD'];

//table name
$table = "fav";

if ($method == 'GET') {
    $username = mysqli_real_escape_string($conn, $_GET['username']);
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT COUNT(*) AS count FROM fav WHERE `favBy` = '$username' AND `outfit_id` = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        if ($data['count'] > 0) {
            $response['isFav'] = true;
        }
        $response['success'] = true;
    }
}

echo json_encode($response);
mysqli_close($conn);
