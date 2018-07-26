<?php
include '../../../db/db_conn.php';
include '../../../models/Debtor.php';
$params = json_decode(file_get_contents("php://input"));
$ids = $_POST['ids'];
$debtor = new Debtor();
$debtor->delete($ids, $_POST['username']);
$responses = array();
$responses["error"] = 0;
$responses["message"] = "Successfully deleted";
echo json_encode($responses, JSON_UNESCAPED_SLASHES);