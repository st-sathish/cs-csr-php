<?php
include '../../../models/User.php';
$response = array();
$params = json_decode(file_get_contents("php://input"));
if (isset($params->email) and isset($params->device_token)) {
    $email = $params->email;
    $device_token = $params->device_token;
    $user = new User();
    $user->modify_user_device_token($email, $device_token);
    $response["valid"] = true;
    $response["message"] = "Successfully Registered.";
    echo json_encode($response);
} else {
    $response["valid"] = false;
    $response["message"] = "Required field(s) missing";
    echo json_encode($response);
}