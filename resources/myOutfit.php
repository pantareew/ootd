<?php
include "./db_connection.php";
header('Content-Type: application/json');
$response = array('success' => false, 'message' => '');
$method = $_SERVER['REQUEST_METHOD'];

//check db connection
if (!$conn) {
    $response['message'] = 'DB connection failed';
    echo json_encode($response);
    exit();
}

//table name
$table = "outfits";

// Check that uploads directory exists
$uploads_dir = __DIR__ . '/uploads';
if (!is_dir($uploads_dir)) {
    $response['message'] = 'Unable to find uploads directory';
    echo json_encode($response);
    exit();
}

$sql = '';
switch ($method) {
    case 'GET':
        if (isset($_GET['username'])) {
            $username = mysqli_real_escape_string($conn, $_GET['username']);
            $sql = "SELECT * FROM `$table` WHERE styler='$username'";
        }
        break;
    case 'POST':
        if (isset($_FILES['img'])) {
            $img_name = $_FILES['img']['name'];
            $img_size = $_FILES['img']['size'];
            $tmp_name = $_FILES['img']['tmp_name'];
            $error = $_FILES['img']['error'];

            if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = $uploads_dir . '/' . $new_img_name;
                    if (move_uploaded_file($tmp_name, $img_upload_path)) {
                        $styler = mysqli_real_escape_string($conn, $_POST['styler']);
                        $desc = mysqli_real_escape_string($conn, $_POST['desc']);
                        $date = mysqli_real_escape_string($conn, $_POST['date']);
                        // SQL query
                        $sql = "INSERT INTO `$table` (styler, `desc`, date, image) VALUES ('$styler', '$desc', '$date', '$new_img_name')";
                    } else {
                        $response['message'] = 'Failed to move uploaded file';

                        echo json_encode($response);
                        exit();
                    }
                } else {
                    $response['message'] = 'File type is not allowed';
                    echo json_encode($response);
                    exit();
                }
            } else {
                $response['message'] = 'File upload error';
                echo json_encode($response);
                exit();
            }
        } else {
            $response['message'] = 'No file uploaded';
            echo json_encode($response);
            exit();
        }
        break;
    case 'PUT':
        $input = json_decode(file_get_contents("php://input"), true);
        $date = mysqli_real_escape_string($conn, $_GET['date']);
        $username = mysqli_real_escape_string($conn, $_GET['username']);
        $desc = mysqli_real_escape_string($conn, $input['desc']);
        $sql = "UPDATE `$table` SET `desc` = '$desc' WHERE `date` = '$date' AND `styler` = '$username'";
        break;
    case 'DELETE':
        $date = mysqli_real_escape_string($conn, $_GET['date']);
        $username = mysqli_real_escape_string($conn, $_GET['username']);
        $sql = "DELETE FROM `$table` WHERE `date` = '$date' AND `styler` = '$username'";
        break;
}


// execute SQL statement
$result = mysqli_query($conn, $sql);
if ($result) {
    $response['success'] = true;
    if ($method == 'POST') {
        $response['file'] = $new_img_name;
    } elseif ($method == 'GET') {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $response['data'] = $data;
    } elseif ($method == 'PUT') {
        if (mysqli_affected_rows($conn) > 0) {
            $response['message'] = "Outfit's description is successfully updated";
        } else {
            $response['message'] = "Selected date is not matched. Try again!";
        }
    } elseif ($method == 'DELETE') {
        if (mysqli_affected_rows($conn) > 0) {
            $response['message'] = "Outfit is deleted successfully";
        } else {
            $response['message'] = "No matching data found to delete. Select new date!";
        }
    }
}
echo json_encode($response);
// close mysql connection
mysqli_close($conn);
