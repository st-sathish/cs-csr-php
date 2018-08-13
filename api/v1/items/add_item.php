<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
$params = json_decode(file_get_contents("php://input"), true);
$itemName = $params["item_name"];
$barcode = $params["barcode"];
$price = $params["purchase_price"];
$s_price = $params["selling_price"];
$expirydate = $params["expiry_date"];
$username = $params["username"];
$category = $params["category"];
$ca = new Item();
$ca->save_item($itemName, $barcode, $price, $s_price, $expirydate, $username, $category);
$response = array();
$response["message"] = "Successfully Added";
$response["success"] = 1;
echo json_encode($response, JSON_UNESCAPED_SLASHES);
?>