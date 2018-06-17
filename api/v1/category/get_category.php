<?php
include '../../../db/db_conn.php';
include '../../../models/Category.php';
$item_id = $_GET['item_id'];
$ca = new Category();
echo json_encode($ca->get_category($item_id), JSON_UNESCAPED_SLASHES);