<?php
include '../../db/db_conn.php';
include '../../utils/EmailUtils.php';
include '../../models/Debtor.php';
include '../../models/User.php';

$params = json_decode(file_get_contents("php://input"));
$ids = $_POST['ids'];
$debtor = new Debtor();
$user = new User();
$debtors = $debtor->get_debtors_by_ids($ids);
$from = $user->get_admin_email();
$response = EmailUtils::send_debt_email($from, $debtors);
echo json_encode($response, JSON_UNESCAPED_SLASHES);