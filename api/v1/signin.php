<?php
include '../../db/db_conn.php';
$response = array();
$params = json_decode(file_get_contents("php://input"));
if (isset($params->email) and isset($params->password)) {
    $email = $params->email;
    $password = md5($params->password);

    $query = "SELECT u.* FROM csr_user u WHERE u.username='$email' and u.password='$password'";
    $result = mysqli_query($conn,$query);
    $count=mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    if ($count >= 1) {
        $response["message"] = "Login success";
        $response["valid"] = true;
        $response["user"] = $row;
        unset($response['user']["password"]);
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
    } else {
        $response["valid"] = false;
        $response["message"] = "Username/password invalid.";
        echo json_encode($response);
    }
} else {
    $response["valid"] = false;
    $response["message"] = "Required field(s) missing";
    echo json_encode($response);
}
