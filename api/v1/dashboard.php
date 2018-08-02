<?php
include '../../db/db_conn.php';
$responses = array();
$meta_data = array();
$today = date("Y-m-d");
$year = date("Y");
$sql = "SELECT * from csr_items where YEAR(modified_at) <= '$year'";
$result = mysqli_query($GLOBALS['conn'], $sql);
$stocks = 0;
$sold = 0;
$expired = 0;
$s_price = 0;
$p_price = 0;
while ($row = $result->fetch_assoc()) {
	if($row['is_sold'] == 1) {
		$sold += 1;
	}
	if($row['is_sold'] == 0 && $row['expiry_date'] < $today) {
		$expired += 1;
	} else if($row['is_sold'] == 0 && $row['expiry_date'] > $today){
		$stocks += 1;
	}
	if($row['is_sold'] == 1 && $row['expiry_date'] > $today) {
		$s_price += floatval($row["selling_price"]);
		$p_price += floatval($row["purchase_price"]);
	}
}
$profit = $s_price - $p_price;
$meta_data["total_sold"] = $sold;
$meta_data["total_expired"] = $expired;
$meta_data["total_stock"] = $stocks;
$meta_data["total_profit"] = $profit;
$responses['meta_data'] = $meta_data;
$responses['banner_message'] = $year. ' review till today';
echo json_encode($responses, JSON_UNESCAPED_SLASHES);