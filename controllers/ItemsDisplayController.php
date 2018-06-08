<?php
session_start();
include '../db/db_conn.php';
include '../models/Item.php';
$response = array();
$params = json_decode(file_get_contents("php://input"));
$ca = new Item();
echo json_encode($ca->get_items(), JSON_UNESCAPED_SLASHES);
