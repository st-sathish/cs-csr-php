<?php
session_start();
include '../db/db_conn.php';
include '../models/Category.php';
$response = array();
$params = json_decode(file_get_contents("php://input"));
$ca = new Category();
echo json_encode($ca->get_categories(), JSON_UNESCAPED_SLASHES);
