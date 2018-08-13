<?php
include '../../../db/db_conn.php';
include '../../../models/Category.php';
$ca = new Category();
$response = array();
$response["data"] = $ca->get_categories();
echo json_encode($response, JSON_UNESCAPED_SLASHES);