<?php
include '../../../db/db_conn.php';
include '../../../models/Category.php';
$ca = new Category();
echo json_encode($ca->get_categories(), JSON_UNESCAPED_SLASHES);