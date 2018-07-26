<?php
include '../../../db/db_conn.php';
include '../../../models/Debtor.php';
$debtor_id = $_GET['debtor_id'];
$debtor = new Debtor();
echo json_encode($debtor->get_debtor($debtor_id), JSON_UNESCAPED_SLASHES);