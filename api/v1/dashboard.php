<?php
include '../../db/db_conn.php';
$responses = array();
$meta_data = array();
$today = date("Y-m-d");
$year = date("Y");
$sql = "SELECT * from csr_items where YEAR(modified_at) <= '$year'";
$result = mysqli_query($GLOBALS['conn'], $sql);
$stocks = mysqli_num_rows($result);
$sold = 0;
$expired = 0;
while ($row = $result->fetch_assoc()) {
	if($row['is_sold'] == 1) {
		$sold += 1;
	}
	if($row['expiry_date'] < $today) {
		$expired += 1;
	}
}
$meta_data["total_sold"] = $sold;
$meta_data["total_expired"] = $expired;
$meta_data["total_stock"] = $stocks;
$meta_data["total_profit"] = 0;
$responses['meta_data'] = $meta_data;
$responses['banner_message'] = 'Your '  . $year. ' review';
echo json_encode($responses, JSON_UNESCAPED_SLASHES);