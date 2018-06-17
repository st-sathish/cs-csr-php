<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
$item_id = $_GET['item_id'];
$item = new Item();
echo json_encode($item->get_item($item_id), JSON_UNESCAPED_SLASHES);