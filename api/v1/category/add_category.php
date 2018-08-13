<?php
include '../../../db/db_conn.php';
include '../../../models/Category.php';
$params = json_decode(file_get_contents("php://input"), true);
$category = $params["category_name"];
$username = $params["username"];
$ca = new Category();
$ca->save_category($category, $username);
$response = array();
$response["message"] = "Successfully Added";
$response["success"] = 1;
echo json_encode($response, JSON_UNESCAPED_SLASHES);
?>