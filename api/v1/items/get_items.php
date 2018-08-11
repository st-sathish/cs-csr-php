<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
include_once '../../../utils/ItemDateUtils.php';
$params = json_decode(file_get_contents("php://input"), true);
$item = new Item();
if(!isset($params['limit'])) {
	$params['limit'] = 10;
}
if(!isset($params['page'])) {
	$params['offset'] = 0;
} else {
	$params['offset'] = $params['page'];
}
if(!isset($params['search'])) {
	$params['search'] = '';
}
echo json_encode($item->get_items($params, ItemDateUtils::get_notification_dates()), JSON_UNESCAPED_SLASHES);