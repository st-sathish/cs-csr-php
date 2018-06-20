<?php
include '../../../db/db_conn.php';
include '../../../models/Item.php';
$item = new Item();
echo json_encode($item->get_items(), JSON_UNESCAPED_SLASHES);