<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
$params = json_decode(file_get_contents("php://input"));
$item = new Item();
if(!isset($params['limit'])) {
	$params['limit'] = 10;
}
if(!isset($params['offset'])) {
	$params['offset'] = 0;
} 
echo json_encode($item->get_items($params), JSON_UNESCAPED_SLASHES);