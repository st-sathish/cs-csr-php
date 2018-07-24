<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
$params = json_decode(file_get_contents("php://input"));
$ids = $_POST['ids'];
$item = new Item();
$item->mark_as_expired($ids, $_POST['username']);
$responses = array();
$responses["error"] = 0;
$responses["message"] = "Successfully marked as expired";
echo json_encode($responses, JSON_UNESCAPED_SLASHES);