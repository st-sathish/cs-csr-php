<?php
session_start();
include '../db/db_conn.php';
include '../models/Item.php';
include_once '../utils/ItemDateUtils.php';
include_once '../utils/ItemDataTableUtils.php';

$response = array();
$params = json_decode(file_get_contents("php://input"));
$requestData = $_REQUEST;
$params["search"] = $requestData['search']['value'];
$params["offset"] = $requestData['start'];
$params["limit"] = $requestData['length'];
$item = new Item();
$response = array();
if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'expired') {
		$items = $item->get_all_expired_items($params);
	} else if ($_REQUEST['action'] == 'sold') {
		$items = $item->get_all_sold_items($params);
	}
} else {
	$items = $item->get_items($params, ItemDateUtils::get_notification_dates());
	$items['data'] = ItemDataTableUtils::formatResult($items['data']);
}
$response["recordsTotal"] = $items['total_record'];
$response["recordsFiltered"] = $items['total_record'];
$response['draw'] = $requestData['draw'];
$response["data"] = $items['data'];
echo json_encode($response, JSON_UNESCAPED_SLASHES);
