<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
$item = new Item();
$response = array();
$limit = 10;
$page = 1;
$response["total_record"] = $item->get_total_items($page, $limit);
$response["page"] = $page;
$response["data"] = $item->get_items();
echo json_encode($response, JSON_UNESCAPED_SLASHES);