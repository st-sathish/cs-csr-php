<?php
session_start();
include '../db/db_conn.php';
include '../models/Debtor.php';
include_once '../utils/ItemDateUtils.php';
include_once '../utils/ItemDataTableUtils.php';

$response = array();
$params = json_decode(file_get_contents("php://input"));
$requestData = $_REQUEST;
$params["search"] = $requestData['search']['value'];
$params["offset"] = $requestData['start'];
$params["limit"] = $requestData['length'];
$debtor = new Debtor();
$response = array();
$debtors = $debtor->get_debtors($params);
$response["recordsTotal"] = $debtors['total_record'];
$response["recordsFiltered"] = $debtors['total_record'];
$response['draw'] = $requestData['draw'];
$response["data"] = $debtors['data'];
echo json_encode($response, JSON_UNESCAPED_SLASHES);
