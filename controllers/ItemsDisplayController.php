<?php
session_start();
include '../db/db_conn.php';
include '../models/Item.php';
$response = array();
$params = json_decode(file_get_contents("php://input"));
$requestData = $_REQUEST;
$params["search"] = $requestData['search']['value'];
$params["offset"] = $requestData['start'];
$params["limit"] = $requestData['length'];
$item = new Item();
$items = $item->get_items($params);
$response = array();
$response["recordsTotal"] = $items['total_record'];
$response["recordsFiltered"] = $items['total_record'];
$response['draw'] = $requestData['draw'];
$response["data"] = $items['data'];
echo json_encode($response, JSON_UNESCAPED_SLASHES);
