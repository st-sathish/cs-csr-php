<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
$item = new Item();
$limit = 10;
$page = 1;
echo json_encode($item->get_items(), JSON_UNESCAPED_SLASHES);